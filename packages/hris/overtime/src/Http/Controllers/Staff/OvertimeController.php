<?php

namespace Hris\Overtime\Http\Controllers\Staff;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Hris\Overtime\Requests\OvertimeRequest;
use Hris\Overtime\Models\Overtime;
use Hris\Overtime\Models\Overtimereason;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Overtime::query();
        $query->with(['user:id,name', 'branch:id,name', 'category:id,title']);
        $filter = $this->filterQuery($query);
        $overtimes = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        $staffs = User::active()
        ->when($request->branch, function($query){
            $query->where('branch_id', request()->branch);
        })
        ->get(['id', 'name']);
        return Inertia::render('Staff/Overtimes/Index', [
            'overtimes' => $overtimes,
            'staffs' => $staffs,
            'branches' => Branch::branchList(),
            'categories' => Overtimereason::orderBy('title')->get(['id', 'title']),
            'filters' => $request->only(['branch', 'user', 'category', 'status', 'type'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Staff/Overtimes/Create', [
            'categories' => Overtimereason::orderBy('title')->get(['id', 'title']),
            'staffs' => User::active()->branchId()->get(['id','name']),
            'holidays' => AppConstant::YN
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Overtime\OvertimeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OvertimeRequest $request)
    {
        Overtime::create($request->validated());
        return redirect()->route('staffs.overtimes.index')->with('success', 'Overtime Saved!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show(Overtime $overtime)
    {
        $is_supervisor = false;
        $user = User::find($overtime->user_id);
        if($user->supervisor_id == auth()->id())
            $is_supervisor = true;
        $overtime->load(['user:id,name', 'category:id,title']);
        return Inertia::render('Staff/Overtimes/Show', [
            'overtime' => $overtime,
            'is_supervisor' => $is_supervisor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OvertimeRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtime $overtime)
    {
        return Inertia::render('Staff/Overtimes/Edit', [
            'overtime' => $overtime,
            'staffs' => User::active()->branchId()->get(['id','name']),
            'categories' => Overtimereason::orderBy('title')->get(['id', 'title']),
            'holidays' => AppConstant::YN
        ]);
    }

    public function update(OvertimeRequest $request, Overtime $overtime)
    {
        $overtime->update($request->validated());
        return redirect()->route('staffs.overtimes.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtime $overtime)
    {
        $overtime->delete();
        return back()->with('success', 'Record Deleted');
    }

    public function changeStatus(Request $request, $id)
    {
        $overtime = Overtime::findOrFail($id);
        $overtime->update(['status' => $request->status]);
        return back()->with('success', 'Overtime Status Updated');
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
        if(request()->filled('type')){
            if(request()->type == 1)
            {
                $subordinateIds = User::active()->branchId()->subordinate()->pluck('id');
                $query->whereIn('user_id', $subordinateIds);
            }
            if(request()->type == 2)
            {
                $query->where('branch_id', auth()->user()->branch_id);
            }else{
                $query->where('user_id', auth()->id());
            }
        }else{
            $query->where('user_id', auth()->id());
        }
        if(request()->filled('category'))
        {
            $query->where('overtime_reason_id', request()->category);
        }
        if(request()->filled('staff'))
        {
            $query->where('user_id', request()->staff);
        }
        if(request()->filled('from'))
        {
            $query->whereDate('login_date', '>=', request()->from);
        }
        if(request()->filled('to'))
        {
            $query->whereDate('login_date', '<=', request()->to);
        }
        return $query;
    }

}

