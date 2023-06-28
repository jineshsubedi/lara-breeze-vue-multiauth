<?php

namespace Hris\Revenue\Http\Controllers\Admin;

use Hris\Revenue\Requests\RevenueRequest;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Hris\Revenue\Models\Division;
use Hris\Revenue\Models\Revenue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Revenue::query();
        $query->with(['branch:id,name', 'division:id,title']);
        $filter = $this->filterQuery($query);
        $revenues = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/Revenues/Index', [
            'revenues' => $revenues,
            'branches' => Branch::branchList(),
            'divisions' => Division::orderBy('title')->get(['id', 'title']),
            'filters' => $request->only(['division', 'branch_id'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Revenues/Create',[
            'divisions' => Division::orderBy('title')->get(['id', 'title']),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Revenue\RevenueRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RevenueRequest $request)
    {
        foreach($request->category as $cat)
        {
            Revenue::create([
                'branch_id' => auth()->user()->branch_id,
                'division_id' => $cat['division_id'],
                'revenue' => $cat['revenue'],
                'direct_expenses' => $cat['direct_expenses'],
                'indirect_expenses' => $cat['indirect_expenses'],
                'net_profit' => $cat['net_profit'],
                'add_date' => date('Y-m-d'),
            ]);
        }
        return redirect()->route('admin.revenues.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RevenueRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function edit(Revenue $revenue)
    {
        return Inertia::render('Admin/Revenues/Edit', [
            'revenue' => $revenue,
            'divisions' => Division::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function update(RevenueRequest $request, Revenue $revenue)
    {
        $revenue->update($request->validated());
        return redirect()->route('admin.revenues.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Revenue $revenue)
    {
        $revenue->delete();
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
        if(request()->filled('division')) {
            $query->where('division_id', request()->division);
        }
        return $query;
    }

}

