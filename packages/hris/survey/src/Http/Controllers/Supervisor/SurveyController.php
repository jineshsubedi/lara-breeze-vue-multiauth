<?php

namespace Hris\Survey\Http\Controllers\Supervisor;

use Hris\Survey\Imports\SurveyQuestionBulkImport;
use Hris\Survey\Requests\SurveyQuestionRequest;
use Hris\Survey\Requests\SurveyRequest;
use Hris\Survey\Models\SurveyQuestion;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Hris\Survey\Models\SurveyAnswer;
use Hris\Survey\Models\Survey;
use Illuminate\Http\Request;
use App\Enums\AppConstant;
use App\Models\Branch;
use Inertia\Inertia;

class SurveyController extends Controller
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
        $query = Survey::query();
        $query->with(['answer' => function($query){
            $query->groupBy('user_id', 'survey_id')->select('id', 'user_id', 'survey_id');
        }])->withCount(['question']);
        $filter = $this->filterQuery($query);
        $surveys = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();
        $branches = Branch::branchList();
        return Inertia::render('Supervisor/Surveys/Index', [
            'surveys' => $surveys,
            'branches' => $branches,
            'filters' => $request->only(['title', 'branch', 'from', 'to'])
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = AppConstant::YN;
        return Inertia::render('Supervisor/Surveys/Create', [
            'data' => $data
        ]);
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
        $data['status'] = AppConstant::YN;
        return Inertia::render('Supervisor/Surveys/Edit', [
            'survey' => $survey,
            'data' => $data,
        ]);
    }

    public function update(SurveyRequest $request, Survey $survey)
    {
        $survey->update($request->validated());
        return redirect()->route('admin.surveys.index')->with('success', 'Record Updated');
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
        }else{
            if(request()->filled('branch')) {
                $query->where('branch_id', request()->branch);
            }
        }
        if(request()->filled('title')) {
            $query->where('title', 'LIKE', '%'.request()->title.'%');
        }
        if(request()->filled('from')) {
            $query->whereDate('start_date', '>=', request()->from);
        }
        if(request()->filled('to')) {
            $query->whereDate('start_date', '<=', request()->to);
        }
        return $query;
    }

    public function getQuestion($id)
    {
        $survey = Survey::findOrFail($id);
        $questions = SurveyQuestion::where('survey_id', $id)->orderBy('sort')->get();
        $data['required'] = AppConstant::YN;
        $data['type'] = AppConstant::FORM_TYPE;
        $data['sample'] = url('assets/files/sampleSurveyQuestion.xlsx');
        return Inertia::render('Supervisor/Surveys/Question', [
            'survey' => $survey,
            'questions' => $questions,
            'data' => $data,
        ]);
    }

    public function postQuestion(SurveyQuestionRequest $request, $id)
    {
        $survey = Survey::findOrFail($id);
        SurveyQuestion::create([
            'survey_id' => $survey->id
        ]   + $request->validated()); 
        return back()->with('success', 'Question Added');
    }

    public function deleteQuestion($id)
    {
        $question = SurveyQuestion::find($id);
        $question->delete();
        return back()->with('success', 'Question Deleted');
    }

    public function autocomplete(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);
        $results[] = ['id' => 0, 'value' => 'ROOT'];
        $term = $request->term;
        $queries = SurveyQuestion::where('label', 'LIKE', $term.'%')
                            ->where('survey_id', $survey->id)
                            ->select('id','label')
                            ->groupBy('label', 'id')
                            ->take(10)
                            ->get();

        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->label ];
        }
        return response()->json($results);
    }
    public function bulkimport(Request $request, $id)
    {
        $this->validate($request, [
            'document' => 'required|mimes:xlsx,xls'
        ]);
        $survey = Survey::findOrFail($id);
        $import = Excel::import(new SurveyQuestionBulkImport($id), request()->file('document'));
		if(!$import)
		{
			return back()->with('danger', 'Something Went Wrong!');
		}
		return back()->with('success', 'Bulk Import Complete!');
    }

    public function participants($id)
    {
        $survey = Survey::findOrFail($id);
        $participants = SurveyAnswer::with('user:id,name')->where('survey_id', $survey->id)
                    ->groupBy('survey_id', 'user_id')
                    ->get();
        return Inertia::render('Staff/Surveys/Participants', [
            'survey' => $survey,
            'participants' => $participants,
        ]);
    }
    public function participants_detail($id, $user_id)
    {
        $survey = Survey::findOrFail($id);
        if($survey->branch_id != auth()->user()->branch_id)
        {
            return back()->with('warning', 'Invalid Survey');
        }
        $survey->load(['answer' => function($q) use($user_id){
            $q->where('user_id', $user_id);
        }]);
        
        return Inertia::render('Supervisor/Surveys/Show', [
            'survey' => $survey
        ]);
    }

}

