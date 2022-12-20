<?php

namespace Hris\Adjustment\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Hris\Adjustment\Requests\AdjustmentRequest;
use Hris\Adjustment\Models\Adjustment;
use Hris\Adjustment\Models\Adjustmentreason;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Adjustment::query();
        $query->with(['user:id,name', 'branch:id,name', 'inform:id,name', 'category:id,title']);
        $filter = $this->filterQuery($query);
        $adjustments = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        $staffs = User::active()
        ->when($request->branch, function($query){
            $query->where('branch_id', request()->branch);
        })
        ->get(['id', 'name']);
        return Inertia::render('Staff/Adjustments/Index', [
            'adjustments' => $adjustments,
            'staffs' => $staffs,
            'branches' => Branch::branchList(),
            'categories' => Adjustmentreason::orderBy('title')->get(['id', 'title']),
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
        return Inertia::render('Staff/Adjustments/Create', [
            'categories' => Adjustmentreason::orderBy('title')->get(['id', 'title']),
            'staffs' => User::active()->branchId()->get(['id','name'])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Adjustment\AdjustmentRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdjustmentRequest $request)
    {
        Adjustment::create($request->validated());
        return redirect()->route('staffs.adjustments.index')->with('success', 'Adjustment Saved!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adjustment  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function show(Adjustment $adjustment)
    {
        $is_supervisor = false;
        $user = User::find($adjustment->user_id);
        if($user->supervisor_id == auth()->id())
            $is_supervisor = true;
        $adjustment->load(['user:id,name', 'category:id,title', 'inform:id,name']);
        return Inertia::render('Staff/Adjustments/Show', [
            'adjustment' => $adjustment,
            'is_supervisor' => $is_supervisor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdjustmentRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Adjustment  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function edit(Adjustment $adjustment)
    {
        return Inertia::render('Staff/Adjustments/Edit', [
            'adjustment' => $adjustment,
            'staffs' => User::active()->branchId()->get(['id','name']),
            'categories' => Adjustmentreason::orderBy('title')->get(['id', 'title'])
        ]);
    }

    public function update(AdjustmentRequest $request, Adjustment $adjustment)
    {
        $adjustment->update($request->validated());
        return redirect()->route('staffs.adjustments.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adjustment  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adjustment $adjustment)
    {
        $adjustment->delete();
        return back()->with('success', 'Record Deleted');
    }

    public function changeStatus(Request $request, $id)
    {
        $adjustment = Adjustment::findOrFail($id);
        $adjustment->update(['status' => $request->status]);
        return back()->with('success', 'Adjustment Status Updated');
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
            $query->where('adjustment_reason_id', request()->category);
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

