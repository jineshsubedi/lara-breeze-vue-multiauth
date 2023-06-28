<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RecruitmentProcessRequest;
use App\Http\Controllers\Controller;
use App\Models\RecruitmentProcess;
use Inertia\Inertia;

class RecruitmentProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = RecruitmentProcess::query();
        $filter = $this->filterQuery($query);
        $recruitmentprocesses = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/RecruitmentProcesses/Index', [
            'recruitmentprocesses' => $recruitmentprocesses
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/RecruitmentProcesses/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RecruitmentProcess\RecruitmentProcessRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RecruitmentProcessRequest $request)
    {
        RecruitmentProcess::create($request->validated());
        return redirect()->route('admin.recruitmentprocesses.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecruitmentProcess  $recruitmentprocess
     * @return \Illuminate\Http\Response
     */
    public function show(RecruitmentProcess $recruitmentprocess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RecruitmentProcessRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RecruitmentProcess  $recruitmentprocess
     * @return \Illuminate\Http\Response
     */
    public function edit(RecruitmentProcess $recruitmentprocess)
    {
        return Inertia::render('Admin/RecruitmentProcesses/Edit', [
            'recruitmentprocess' => $recruitmentprocess
        ]);
    }

    public function update(RecruitmentProcessRequest $request, RecruitmentProcess $recruitmentprocess)
    {
        $recruitmentprocess->update($request->validated());
        return redirect()->route('admin.recruitmentprocesses.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecruitmentProcess  $recruitmentprocess
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecruitmentProcess $recruitmentprocess)
    {
        $recruitmentprocess->delete();
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

