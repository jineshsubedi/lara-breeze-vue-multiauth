<?php

namespace Hris\Survey\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hris\Survey\Models\Survey;
use Hris\Survey\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SurveyAnswerController extends Controller
{
    protected $disk = 'public';
    protected $path = 'survey';

    public function index(Request $request)
    {
        $surveys = Survey::with(['branch:id,name'])->withCount(['answer' => function($q){
            $q->where('user_id', auth()->id());
        }])
        ->where('branch_id', auth()->user()->branch_id)
        ->where('status', 1)
        ->paginate(10);
        return Inertia::render('Admin/Mysurveys/Index', [
            'surveys' => $surveys
        ]);
    }
    public function show($id)
    {
        $survey = Survey::findOrFail($id);
        if($survey->branch_id != auth()->user()->branch_id)
        {
            return back()->with('warning', 'Invalid Survey');
        }
        $survey->load(['branch:id,name', 'question', 'answer' => function($q){
            $q->where('user_id', auth()->id());
        }]);
        if(count($survey->answer) > 0)
        {
            return Inertia::render('Admin/Mysurveys/Detail', [
                'survey' => $survey
            ]);
        }
        return Inertia::render('Admin/Mysurveys/Show', [
            'survey' => $survey
        ]);
    }

    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        foreach($request->myanswer as $k=>$myanswer)
        {
            $answer = '';
            if($myanswer['type'] == 'file')
            {
                if($request->hasFile('myanswer.'.$k.'.answer'))
                {
                    $validator = Validator::make($request->all(),
                        [
                            'myanswer.'.$k.'.answer' => 'required|mimes:jpg,png,jpeg,doc,docx,pdf,csv,xlsx,xls|max:2048'
                        ], [
                            'mimes' => 'File must be in valid format',
                            'max' => 'File size must be under 2MB'
                        ]
                    );
                    if ($validator->fails())
                    {
                        DB::rollBack();
                        return back()
                                ->withErrors($validator)
                                ->withInput();
                    }
                    $file = $request->myanswer[$k]['answer'];
                    $answer = $file->store($this->path.'/'.$id, $this->disk);
                    $answer = Storage::url($answer);
                    $answer = '<a href="'.$answer.'" target="_blank">CLick To Open</a>';
                }
            }
            elseif($myanswer['type'] == 'checkbox')
            {
                $answer = implode(',' , $myanswer['answer']);
            }
            else{
                $answer = $myanswer['answer'];
            }
            SurveyAnswer::create([
                'survey_id' => $id,
                'user_id' => auth()->id(),
                'question' => $myanswer['question'],
                'answer' => $answer
            ]);
        }
        DB::commit();
        return redirect()->route('admin.mysurveys.index')->with('success', 'Survey Complete!');
    }
}
