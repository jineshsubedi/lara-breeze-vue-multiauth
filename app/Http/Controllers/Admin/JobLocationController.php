<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\JobLocationRequest;
use App\Http\Controllers\Controller;
use App\Models\JobLocation;
use Inertia\Inertia;

class JobLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = JobLocation::query();
        $filter = $this->filterQuery($query);
        $joblocations = $filter->orderBy('name')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/JobLocations/Index', [
            'joblocations' => $joblocations
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/JobLocations/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\JobLocation\JobLocationRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JobLocationRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'name' => $st['name'],
            ];
            JobLocation::create($data);
        }
        return redirect()->route('admin.joblocations.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobLocation  $joblocation
     * @return \Illuminate\Http\Response
     */
    public function show(JobLocation $joblocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\JobLocationRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobLocation  $joblocation
     * @return \Illuminate\Http\Response
     */
    public function edit(JobLocation $joblocation)
    {
        return Inertia::render('Admin/JobLocations/Edit', [
            'joblocation' => $joblocation
        ]);
    }

    public function update(JobLocationRequest $request, JobLocation $joblocation)
    {
        $joblocation->update($request->validated());
        return redirect()->route('admin.joblocations.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobLocation  $joblocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobLocation $joblocation)
    {
        $joblocation->delete();
        return back()->with('success', 'Record Deleted');
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

