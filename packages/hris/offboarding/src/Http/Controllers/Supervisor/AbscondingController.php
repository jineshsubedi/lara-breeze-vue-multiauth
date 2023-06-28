<?php

namespace Hris\Offboarding\Http\Controllers\Supervisor;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hris\Offboarding\Enums\OffboardActionType;
use Hris\Offboarding\Enums\TerminationStatus;
use Hris\Offboarding\Models\Absconding;
use Hris\Offboarding\Models\TerminationStaff;
use Hris\Offboarding\Models\TerminationType;
use Hris\Offboarding\Requests\AbscondingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AbscondingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:HrHandler');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Absconding::query();
        $query->with(['branch:id,name','user:id,name','isseudby:id,name']);
        $filter = $this->filterQuery($query);
        $abscondings = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Offboard/Abscondings/Index', [
            'abscondings' => $abscondings,
            'terminationStatus' => config('offboardConstant.termination_status'),
            'termination_status' => TerminationStatus::TERMINATE->value,
            'terminationTypes' => TerminationType::branchId()->get(['id', 'title'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Offboard/Abscondings/Create', [
            'datas' => $this->getData(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Absconding\AbscondingRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AbscondingRequest $request)
    {
        if($request->action_type == 1)
        {
            $suspension = 1;
        	$penalty = 0;
        }else{
            $suspension = 0;
        	$penalty = 1;
        }
        Absconding::create($request->validated() + [
            'suspension' => $suspension,
            'penalty' => $penalty,
            'follow_up_attachment' => $request->hasFile('follow_up_attachmentFile') ? ($request->file('follow_up_attachmentFile')->store('absconding', 'public')) : ''
        ]);
        return redirect()->route('supervisor.abscondings.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absconding  $absconding
     * @return \Illuminate\Http\Response
     */
    public function show(Absconding $absconding)
    {
        $absconding->load(['branch:id,name','user:id,name','isseudby:id,name']);
        return Inertia::render('Supervisor/Offboard/Abscondings/Show', [
            'absconding' => $absconding,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AbscondingRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Absconding  $absconding
     * @return \Illuminate\Http\Response
     */
    public function edit(Absconding $absconding)
    {
        $absconding->action_type = $absconding->suspension == OffboardActionType::SUSPENSION->value ? OffboardActionType::SUSPENSION->value : OffboardActionType::PENALTY->value;

        return Inertia::render('Supervisor/Offboard/Abscondings/Edit', [
            'absconding' => $absconding,
            'datas' => $this->getData(),
        ]);
    }

    public function update(AbscondingRequest $request, Absconding $absconding)
    {
        $document_path = $absconding->getRawOriginal('follow_up_attachment');
        if($request->hasFile('follow_up_attachmentFile'))
        {
            if(Storage::exists($document_path))
                Storage::delete($document_path);
            $document_path = $request->file('follow_up_attachmentFile')->store('absconding', 'public');
        }
        if($request->action_type == 1)
        {
            $suspension = 1;
        	$penalty = 0;
        }else{
            $suspension = 0;
        	$penalty = 1;
        }
        $absconding->update($request->validated() + [
            'suspension' => $suspension,
            'penalty' => $penalty,
            'follow_up_attachment' => $document_path
        ]);
        return redirect()->route('supervisor.abscondings.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absconding  $absconding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absconding $absconding)
    {
        $document_path = $absconding->getRawOriginal('follow_up_attachment');
        if($document_path != '')
        {
            if(Storage::exists($document_path))
                Storage::delete($document_path);
        }
        $absconding->delete();
        return back()->with('success', 'Record Deleted');
    }

    public function terminatestaff($id, Request $request)
    {
        $this->validate($request, [
            'termination_type' => 'required',
            'termination_detail' => 'required',
            'offBoarding_date' => 'required|date',
            'status' => 'required',
        ]);
        $disciplinaryaction = Absconding::findOrFail($id);
        $disciplinaryaction->update(['termination' => 1]);
        TerminationStaff::updateOrCreate([
            'user_id' => $disciplinaryaction->user_id,
            'termination_type' => $request->termination_type,
            'offBoarding_date' => $request->offBoarding_date,
            'status' => $request->status
        ], [
            'branch_id' => $disciplinaryaction->branch_id,
            'user_id' => $disciplinaryaction->user_id,
            'termination_type' => $request->termination_type,
            'termination_detail' => $request->termination_detail,
            'offBoarding_date' => $request->offBoarding_date,
            'status' => $request->status,
            'start_date' => $disciplinaryaction->issued_date,
            'end_date' => $disciplinaryaction->issued_date,
            'terminate_by' => auth()->id(),
            'justification_date' => $disciplinaryaction->justification_date,
            'justification_detail' => $disciplinaryaction->justification_detail,
        ]);
        return back()->with('success', 'Staff Terminated');
    }
    public function holdstaff($id)
    {
        $disciplinaryaction = Absconding::findOrFail($id);
        $disciplinaryaction->update(['termination' => 2]);
        return back()->with('success', 'Staff Hold');
    }
    private function getData()
    {
        $data['staffs'] = User::active()->branchId()->get(['id', 'name']);
        $data['communication'] = AppConstant::COMMUNICATION;
        $data['actions'] = config('offboardConstant.actions');
        $data['action_types'] = config('offboardConstant.action_types');

        return $data;
    }

    private function filterQuery($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }
        if(request()->filled('branch')) {
            $query->where('branch_id', request()->branch);
        }
        return $query;
    }

}

