<?php

namespace Hris\Training\Http\Controllers\Admin;

use App\Enums\AppConstant;
use App\Http\Controllers\Controller;
use Hris\Training\Models\Training;
use Hris\Training\Models\TrainingParticipant;
use Hris\Training\Models\TrainingTemplate;
use Hris\Training\Models\TrainingTemplateQuestion;
use Hris\Training\Models\TrainingTemplateQuestionAnswer;
use Hris\Training\Requests\TrainingTemplateRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainingTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $training = Training::with(['program:id,title'])->findOrFail($id);
        $query = TrainingTemplate::query();
        $query->with(['qanswers:id,training_template_id,question,answer,type,score', 'answers' => function($q){
            $q->with(['user:id,name']);
        }]);
        $query->where('training_id', $training->id);
        $filter = $this->filterQuery($query);
        $templates = $filter->latest('id', 'desc')
                          ->paginate(20)
                          ->withQueryString();

        return Inertia::render('Admin/Trainings/Template/Index', [
            'training' => $training,
            'templates' => $templates,
            'datas' => $this->getData(),
            'filters' => request()->only(['title', 'share', 'schedule'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $training = Training::with(['program:id,title'])->findOrFail($id);
        return Inertia::render('Admin/Trainings/Template/Create', [
            'training' => $training,
            'datas' => $this->getData()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, TrainingTemplateRequest $request)
    {
        if($id != $request->training_id)
            return back()->with('danger', 'You Cannot Add this Template');
        $template  = TrainingTemplate::create($request->validated() + [
            'branch_id' => auth()->user()->branch_id
        ]);
        if(count($request->category) > 0)
        {
            $questions = [];
            foreach($request->category as $category)
            {
                $questions[] = [
                    'training_template_id' => $template->id,
                    'question' => $category['question'],
                    'type' => $category['type'],
                    'list_menu' => $category['list_menu'],
                    'mandatory' => $category['mandatory'],
                    'order' => $category['order'],
                ];
            }
            TrainingTemplateQuestion::insert($questions);
        }
        return redirect()->route('admin.trainings.template.index', $id)->with('success', 'Template Added');
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
    public function edit($id, $template_id)
    {
        $training = Training::with(['program:id,title'])->findOrFail($id);
        $template = TrainingTemplate::findOrFail($template_id);
        return Inertia::render('Admin/Trainings/Template/Edit', [
            'training' => $training,
            'template' => $template,
            'category' => TrainingTemplateQuestion::where('training_template_id', $template->id)->orderBy('order')->get(),
            'datas' => $this->getData()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrainingTemplateRequest $request, $id, $template_id)
    {
        $template = TrainingTemplate::findOrFail($template_id);
        if($id != $template->training_id)
            return back()->with('danger', 'You Cannot Update this Template');
        $template->update($request->validated());
        TrainingTemplateQuestion::where('training_template_id', $template->id)->delete();
        if(count($request->category) > 0)
        {
            $questions = [];      
            foreach($request->category as $category)
            {
                $questions[] = [
                    'training_template_id' => $template->id,
                    'question' => $category['question'],
                    'type' => $category['type'],
                    'list_menu' => $category['list_menu'],
                    'mandatory' => $category['mandatory'],
                    'order' => $category['order'],
                ];
            }
            TrainingTemplateQuestion::insert($questions);
        }
        return redirect()->route('admin.trainings.template.index', $id)->with('success', 'Template Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $template_id)
    {
        $template = TrainingTemplate::findOrFail($template_id);
        if($template->training_id != $id)
            return back()->with('danger', 'You Cannot Delete This Training Template');
        $template->delete();
        return back()->with('success', 'Training Template Deleted');
    }

    private function filterQuery($query)
    {
        if(request()->filled('title')) {
            $query->where('title', 'LIKE', '%'.request()->title.'%');
        }
        if(request()->filled('share')) {
            $query->where('share_with', request()->share);
        }
        if(request()->filled('schedule')) {
            $query->where('schedule', request()->schedule);
        }
        return $query;
    }

    private function getData()
    {
        $data['share'] = config('trainingConstant.share');
        $data['types'] = config('trainingConstant.form_type');
        $data['required'] = AppConstant::YN;

        return $data;
    }

    public function evaluationForm($id, $template_id)
    {
        $training = Training::findOrFail($id);
        $template = TrainingTemplate::findOrFail($template_id);
        if($template->share_with != 1)
            return back()->with('warning', 'This Form is Not Schedule for Trainers');

        $questions = TrainingTemplateQuestion::where('training_template_id', $template->id)
                ->orderBy('order')
                ->get();
        return Inertia::render('Admin/Trainings/Template/Evaluation', [
            'training' => $training,
            'template' => $template,
            'questions' => $questions,
            'muti_answer' => config('trainingConstant.answer_options')
        ]);
    }

    public function saveEvaluationForm($id, $template_id, Request $request)
    {
        $this->validate($request,[
            'myanswer.*' => 'required'
        ]);
        $training = Training::findOrFail($id);
        $answers = [];
        foreach($request->myanswer as $ans)
        {
            $answers[] = [
                'question_id' => $ans['question_id'],
                'question' => $ans['question'],
                'type' => $ans['type'],
                'answer' => $ans['type'] == 'multiple' ? $this->multipleChoiceAns($ans['answer']) : $ans['answer'],
                'training_id' => $ans['training_id'],
                'training_template_id' => $ans['training_template_id'],
                'staff_id' => 0,
                'is_trainer' => 1,
                'answer_date' => Date('Y-m-d'),
                'score' => $ans['type'] == 'multiple' ? $ans['answer'] : 0,
            ];
        }
        TrainingTemplateQuestionAnswer::insert($answers);
        return redirect()->route('admin.trainings.template.index', $training->id)->with('success', 'Form Submitted Successfully');
    }
    private function multipleChoiceAns($value)
    {
        $answers = config('trainingConstant.answer_options');
        $key = array_search($value, array_column($answers, 'value'));
        return $answers[$key]['title'];
    }
}
