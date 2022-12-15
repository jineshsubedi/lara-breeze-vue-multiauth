<?php

namespace Hris\Survey\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Hris\Survey\Models\Survey;
use Hris\Survey\Requests\SurveyRequest;
use Inertia\Inertia;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Survey::query();
        $filter = $this->filterQuery($query);
        $surveys = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Supervisor/Surveys/Index', [
            'surveys' => $surveys
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Supervisor/Surveys/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Survey\SurveyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyRequest $request)
    {
        Survey::create($request->validated());
        return redirect()->route('supervisor.surveys.index')->with('success', 'Record Added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SurveyRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        return Inertia::render('Supervisor/Surveys/Edit', [
            'survey' => $survey
        ]);
    }

    public function update(SurveyRequest $request, Survey $survey)
    {
        $survey->update($request->validated());
        return redirect()->route('supervisor.surveys.index')->with('success', 'Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();
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

