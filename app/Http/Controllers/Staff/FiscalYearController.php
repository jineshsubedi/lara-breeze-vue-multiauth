<?php

namespace App\Http\Controllers\Staff;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\FiscalYearRequest;
use App\Models\FiscalYear;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FiscalYearController extends Controller
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
        $query = FiscalYear::query();
        $filter = $this->filterQuery($query);
        $fiscalyears = $filter->orderBy('current_year', 'desc')->paginate(10)->withQueryString();
        return Inertia::render('Staff/Fiscal/Index', [
            'fiscalyears' => $fiscalyears,
            'filters' => $request->only(['title'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cyears = AppConstant::YN;
        return Inertia::render('Staff/Fiscal/Create', [
            'cyears' => $cyears,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FiscalYearRequest $request)
    {
        FiscalYear::create($request->validated());
        return redirect()->route('staffs.fiscalyears.index')->with('success', 'Fiscal Year Added Successfully');
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
    public function edit(FiscalYear $fiscalyear)
    {
        $cyears = AppConstant::YN;
        return Inertia::render('Staff/Fiscal/Edit', [
            'fiscalyear' => $fiscalyear,
            'cyears' => $cyears,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FiscalYearRequest $request, FiscalYear $fiscalyear)
    {
        $fiscalyear->update($request->validated());
        return redirect()->route('staffs.fiscalyears.index')->with('success', 'Fiscal Year Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FiscalYear $fiscalyear)
    {
        if($fiscalyear->current_year == 1) {
            return back()->with('danger', 'Current Fiscal Year Cannot be Deleted');
        }
        $fiscalyear->delete();
        return back()->with('success', 'Fiscal Year Deleted');
    }
    private function filterQuery($query)
    {
        if(request()->filled('title')) {
            $query->where('title','like', '%'. request()->title.'%');
        }
        return $query;
    }
}
