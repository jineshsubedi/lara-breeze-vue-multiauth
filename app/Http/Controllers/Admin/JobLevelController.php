<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\JobLevelRequest;
use App\Http\Controllers\Controller;
use App\Models\JobLevel;
use Inertia\Inertia;

class JobLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = JobLevel::query();
        $filter = $this->filterQuery($query);
        $joblevels = $filter->orderBy('order', 'asc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/JobLevels/Index', [
            'joblevels' => $joblevels
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/JobLevels/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\JobLevel\JobLevelRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JobLevelRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'name' => $st['name'],
                'order' => $st['order'],
            ];
            JobLevel::create($data);
        }
        return redirect()->route('admin.joblevels.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobLevel  $joblevel
     * @return \Illuminate\Http\Response
     */
    public function show(JobLevel $joblevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\JobLevelRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobLevel  $joblevel
     * @return \Illuminate\Http\Response
     */
    public function edit(JobLevel $joblevel)
    {
        return Inertia::render('Admin/JobLevels/Edit', [
            'joblevel' => $joblevel
        ]);
    }

    public function update(JobLevelRequest $request, JobLevel $joblevel)
    {
        $joblevel->update($request->validated());
        return redirect()->route('admin.joblevels.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobLevel  $joblevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobLevel $joblevel)
    {
        $joblevel->delete();
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
        return $query;
    }

}

