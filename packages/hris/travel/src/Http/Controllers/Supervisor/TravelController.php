<?php

namespace Hris\Travel\Http\Controllers\Supervisor;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Models\BranchSetting;
use App\Models\LeaveSetting;
use App\Models\User;
use Carbon\Carbon;
use Hris\Travel\Models\AssignmentCategory;
use Hris\Travel\Models\AssignmentType;
use Hris\Travel\Models\Travel;
use Hris\Travel\Models\TravelDestination;
use Hris\Travel\Models\TravelExpense;
use Hris\Travel\Models\TravelPlanner;
use Hris\Travel\Models\TravelReply;
use Hris\Travel\Requests\TravelApprovalRequest;
use Hris\Travel\Requests\TravelRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $travels = $supervisorApprovals = $accountApprovals = $hrApprovals = $managerApprovals = [];
        $manager = false;
        $query = Travel::query();
        $query->with([
            'assign_from:id,name', 
            'assign_to:id,name',
            'assign_type:id,title',
            'assign_category:id,title',
        ])->withCount('reply');
        $filter = $this->filterQuery($query);
        $staffs  = User::active()->where('supervisor_id', auth()->id())->pluck('id');
        $leaveSetting = LeaveSetting::where('branch_id', auth()->user()->branch_id)->first();
        if($leaveSetting->m_person == auth()->id())
        {
            $manager = true;
        }
        if(request()->filled('tab')) {
            if(request()->tab == 'all')
            {
                $travels = $filter
                        ->latest('id', 'desc')
                        ->paginate(20)
                        ->withQueryString();
            }
            else if(request()->tab == 'mytravel')
            {
                $travels = $filter
                        ->where('assigned_to', auth()->id())
                        ->latest('id', 'desc')
                        ->paginate(20)
                        ->withQueryString();
            }
            else if(request()->tab == 'swaiting')
            {
                $supervisorApprovals = $filter
                    ->where('supervisor_approval', 0)
                    ->whereIn('assigned_to', $staffs)
                    ->orderBy('id', 'desc')
                    ->get();
            
            }
            else if(request()->tab == 'awaiting')
            {
                $accountApprovals = $filter
                    ->where('supervisor_approval', 1)
                    ->where('account_approval', 0)
                    ->orderBy('id', 'desc')
                    ->get();
            }
            else if(request()->tab == 'hwaiting')
            {
                $hrApprovals = $filter
                    ->where('account_approval', 1)
                    ->where('hr_approval', 0)
                    ->orderBy('id', 'desc')
                    ->get();
            }
            else if(request()->tab == 'mwaiting')
            {
                $managerApprovals = $filter
                    ->where('hr_approval', 1)
                    ->where('chairman_approval', 0)
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }else{
            $travels = $filter
                    ->where('assigned_from', auth()->id())
                    ->latest('id', 'desc')
                    ->paginate(20)
                    ->withQueryString();
        }
        $ctravel = new Travel();
        $counter = [
            'supervisor' => $ctravel->where('supervisor_approval', 0)
                                    ->whereIn('assigned_to', $staffs)
                                    ->count(),
            'account' => $ctravel->where('supervisor_approval', 1)
                                ->where('account_approval', 0)
                                ->count(),
            'hr' => $ctravel->where('account_approval', 1)
                            ->where('hr_approval', 0)
                            ->count(),
            'chairman' => $ctravel->where('hr_approval', 1)
                            ->where('chairman_approval', 0)
                            ->count(),
        ];
        return Inertia::render('Supervisor/Travel/Main/Index', [
            'travels' => $travels,
            'supervisorApprovals' => $supervisorApprovals,
            'accountApprovals' => $accountApprovals,
            'hrApprovals' => $hrApprovals,
            'managerApprovals' => $managerApprovals,
            
            'counter' => $counter,
            'manager' => $manager,
            'types' => config('travelConstant.type'),
            'approval' => config('travelConstant.approval'),
            'filters' => request()->only(['type', 'from', 'to', 'tab'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Travel/Main/Create', [
            'datas' => $this->getData()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Travel\TravelRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TravelRequest $request)
    {
        $travel = Travel::create($request->validated());
        if($request->destination)
        {
            foreach($request->destination as $des)
            {
                TravelDestination::create([
                    'travel_id' => $travel->id,
                    'from' => $des['from'],
                    'to' => $des['to'],
                    'departure_date' => $des['departure_date'],
                    'arrival_date' => $des['arrival_date'],
                ]);
            }
        }
        return redirect()->route('supervisor.travels.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function show(Travel $travel)
    {
        $travel->load([
            'destination',
            'reply' => function($q){
                $q->with(['user:id,name,avatar']);
            },
            'assign_from:id,name', 
            'assign_to:id,name',
            'assign_type:id,title',
            'assign_category:id,title',
        ])->loadCount('reply');
        $travel->reply->map(function($q){
            $q->chat_at = Carbon::parse($q->created_at)->format('d M, Y h:i a'); 
            return $q;
        });
        // return $travel;
        $planner = TravelPlanner::with(['itinery', 'road', 'air', 'hotel', 'visa' => function($q){
            $q->with(['user:id,name', 'department:id,title']);
        }])
            ->where('supervisor_approval', '!=', 2)
            ->where('hr_approval', '!=', 2)
            ->where('chairman_approval', '!=', 2)
            ->where('travel_id', $travel->id)
            ->first();

        $expenses = TravelExpense::with('destination')->where('travel_id', $travel->id)->get();

        return Inertia::render('Supervisor/Travel/Main/Show', [
            'travel' => $travel,
            'planner' => $planner,
            'expenses' => $expenses,
            'approval' => config('travelConstant.approval'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TravelRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function edit(Travel $travel)
    {
        $data['road_sub'] = $travel->getRawOriginal('road_sub');
        $data['payment_mode'] = $travel->getRawOriginal('payment_mode');
        $data['reimbursement'] = $travel->getRawOriginal('reimbursement');
        $data['position'] = $travel->getRawOriginal('position');
        $data['grade'] = $travel->getRawOriginal('grade');
        $travel->load(['destination']);
        return Inertia::render('Supervisor/Travel/Main/Edit', [
            'travel' => $travel,
            'data' => $data,
            'datas' => $this->getData()
        ]);
    }

    public function update(TravelRequest $request, Travel $travel)
    {
        $travel->update($request->validated());
        TravelDestination::where('travel_id', $travel->id)->delete();
        if($request->destination)
        {
            foreach($request->destination as $des)
            {
                TravelDestination::create([
                    'travel_id' => $travel->id,
                    'from' => $des['from'],
                    'to' => $des['to'],
                    'departure_date' => $des['departure_date'],
                    'arrival_date' => $des['arrival_date'],
                ]);
            }
        }
        return redirect()->route('supervisor.travels.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Travel $travel)
    {
        $travel->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }else{
            if(request()->filled('branch')) {
                $query->where('branch_id', request()->branch);
            }
        }
        if(request()->filled('type')) {
            $query->where('type', request()->type);
        }
        if(request()->filled('from')) {
            $query->whereDate('from', '>=', request()->from);
        }
        if(request()->filled('to')) {
            $query->whereDate('to', '<=', request()->to);
        }
        return $query;
    }
    
    private function getData()
    {
        $data['types'] = config('travelConstant.type');
        $data['modes'] = config('travelConstant.mode_of_transport');
        $data['road_subs'] = config('travelConstant.road_sub');
        $data['payment_mode'] = config('travelConstant.payment_mode');
        $data['reimbursement'] = config('travelConstant.reimbursement');
        $data['level'] = config('travelConstant.level');
        $data['grade'] = config('travelConstant.grade');
        $data['staffs'] = User::active()->branchId()->orderBy('name')->get(['id', 'name']);
        $data['assignment_types'] = AssignmentType::orderBy('title')->get(['id', 'title']);
        $data['assignment_categories'] = AssignmentCategory::orderBy('title')->get(['id', 'title']);
        $data['advance_required'] = AppConstant::YN;

        return $data;
    }

    public function approval(TravelApprovalRequest $request)
    {
        $travel = Travel::findOrFail($request->travel_id);

        $approval_types = ['supervisor', 'account', 'hr', 'manager'];
        $approval_data = [
            'supervisor' => [
                'approval' => 'supervisor_approval',
                'remark' => 'supervisor_remark'
            ],
            'account' => [
                'approval' => 'account_approval',
                'remark' => 'account_remark'
            ],
            'hr' => [
                'approval' => 'hr_approval',
                'remark' => 'hr_remark'
            ],
            'manager' => [
                'approval' => 'chairman_approval',
                'remark' => 'chairman_remark'
            ],
        ];

        if(in_array($request->type, $approval_types)) {
            $travel->update([
                $approval_data[$request->type]['approval'] => $request->status,
                $approval_data[$request->type]['remark'] => $request->remarks
            ]);
        }

        return back()->with('success', 'Travel Request Updated');
    }

    public function saveReply($id, Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:500'
        ]);
        TravelReply::create([
            'travel_id' => $id,
            'user_id' => auth()->id(),
            'description' => nl2br($request->description)
        ]);
        return back();
    }
}

