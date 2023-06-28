<?php

namespace Hris\Training\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Hris\Training\Models\TrainingProgram;
use Hris\Training\Requests\TrainingProgramRequest;

class TrainingProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = TrainingProgram::query();
        $filter = $this->filterQuery($query);
        $trainingprograms = $filter->orderBy('title')
                          ->paginate(20)
                          ->withQueryString();
        return Inertia::render('Admin/TrainingPrograms/Index', [
            'trainingprograms' => $trainingprograms,
            'filters' => request()->only(['title'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/TrainingPrograms/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TrainingProgram\TrainingProgramRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingProgramRequest $request)
    {
        foreach($request->category as $st)
        {
            $data = [
                'title' => $st['title'],
            ];
            TrainingProgram::create($data);
        }
        return redirect()->route('admin.trainingprograms.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingProgram  $trainingprogram
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingProgram $trainingprogram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TrainingProgramRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrainingProgram  $trainingprogram
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingProgram $trainingprogram)
    {
        return Inertia::render('Admin/TrainingPrograms/Edit', [
            'trainingprogram' => $trainingprogram
        ]);
    }

    public function update(TrainingProgramRequest $request, TrainingProgram $trainingprogram)
    {
        $trainingprogram->update($request->validated());
        return redirect()->route('admin.trainingprograms.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingProgram  $trainingprogram
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingProgram $trainingprogram)
    {
        $trainingprogram->delete();
        return back()->with('success', 'Record Deleted');
    }

    private function filterQuery($query)
    {
        // if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        // {
        //     $query->where('branch_id', auth()->user()->branch_id);
        // }
        if(request()->filled('title')) {
            $query->where('title', 'LIKE', '%'.request()->title.'%');
        }
        return $query;
    }

}
