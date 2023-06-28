<?php

namespace Hris\Holiday\Http\Controllers\Staff;

use Hris\Holiday\Requests\HolidayRequest;
use App\Http\Controllers\Controller;
use Hris\Holiday\Models\Holiday;
use Illuminate\Http\Request;
use App\Models\Branch;
use Inertia\Inertia;

class HolidayController extends Controller
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
    public function index(Request $request)
    {
        $query = Holiday::with(['branch:id,name']);
        $filter = $this->filterQuery($query);
        $holidays = $filter->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $branches = Branch::branchList();
        $defBranch = auth()->user()->branch_id;
        return Inertia::render('Staff/Holiday/Index', [
            'holidays' => fn () => $holidays,
            'branches' => fn () => $branches,
            'defBranch' => fn () => $defBranch,
            'filters' => $request->only(['title', 'from', 'to'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::branchList();
        $defBranch = auth()->user()->branch_id;
        return Inertia::render('Staff/Holiday/Create', [
            'branches' => fn () => $branches,
            'defBranch' => fn () => $defBranch,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayRequest $request)
    {
        Holiday::create($request->validated());
        return redirect()->route('staffs.holidays.index')->with('success', 'Holiday Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        $branches = Branch::branchList();
        $defBranch = auth()->user()->branch_id;
        return Inertia::render('Staff/Holiday/Edit', [
            'holiday' => fn () => $holiday,
            'branches' => fn () => $branches,
            'defBranch' => fn () => $defBranch,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayRequest $request, Holiday $holiday)
    {
        $holiday->update($request->validated());
        return redirect()->route('staffs.holidays.index')->with('success', 'Holiday Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('staffs.holidays.index')->with('success', 'Holiday Deleted Successfully');
    }

    private function filterQuery($query)
    {
        if(request()->filled('title')) {
            $query->where('title','like', '%'. request()->title.'%');
        }
        if(request()->filled('from')) {
            $query->where('start_date',request()->from);
        }
        if(request()->filled('to')) {
            $query->where('end_date',request()->to);
        }
        return $query;
    }
}