<?php

namespace Hris\Training\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hris\Training\Models\Training;
use Hris\Training\Models\TrainingParticipant;
use Hris\Training\Models\TrainingTemplate;
use Hris\Training\Models\TrainingTemplateQuestion;
use Hris\Training\Models\TrainingTemplateQuestionAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyTrainingController extends Controller
{
    public function index()
    {
        $mytrainings = [];
        $templates = [];
        $new_templates = [];
        if(request()->filled('type')) {
            if(request()->type == 'mytraining')
            {
                $mytrainings = TrainingParticipant::with(['training' => function($q){
                    $q->with(['program:id,title', 'trainer:id,name']);
                }])
                    ->where('user_id', auth()->id())
                    ->where('status', 1)
                    ->orderBy('training_id', 'desc')
                    ->paginate(10);
            }
            if(request()->type == 'evaluation')
            {
                $templates = TrainingTemplateQuestionAnswer::with(['training' => function($q){
                    $q->with(['program:id,title']);
                }, 'template'])
                    ->where('staff_id', auth()->id())
                    ->groupBy('training_template_id')
                    ->orderBy('id', 'desc')
                    ->paginate(20)
                    ->withQueryString();

                $answeredTemplate = TrainingTemplateQuestionAnswer::where('staff_id', auth()->id())
                    ->where('is_trainer', 0)
                    ->groupBy('training_template_id')
                    ->pluck('training_template_id');

                $new_templates = TrainingParticipant::leftjoin('training_templates', 'training_participants.training_id', 'training_templates.training_id')
                    ->whereNotIn('training_templates.id', $answeredTemplate)
                    ->where('training_participants.user_id', auth()->id())
                    ->where('training_participants.status', 1)
                    ->where('training_templates.schedule', 1)
                    ->where('training_templates.share_with', '!=', 1)
                    ->whereDate('training_templates.schedule_date', '<=', Date('Y-m-d'))
                    ->whereDate('training_templates.schedule_end_date', '>=', Date('Y-m-d'))
                    ->select('training_templates.*')
                    ->get();
            }
        }else{
            $mytrainings = TrainingParticipant::with(['training' => function($q){
                $q->with(['program:id,title', 'trainer:id,name']);
            }])
                ->where('user_id', auth()->id())
                ->where('status', 1)
                ->orderBy('training_id', 'desc')
                ->paginate(10)
                ->withQueryString();
        }

        return Inertia::render('Staff/Mytrainings/Index', [
            'mytrainings' => $mytrainings,
            'templates' => $templates,
            'new_templates' => $new_templates,
            'filters' => request()->only(['type'])
        ]);
    }

    public function show($id)
    {
        $training = Training::findOrFail($id);
        $training->load(['category', 'notice', 'program', 'trainer', 'materials'])
            ->loadCount(['participant as active_participant' => function($query){
                $query->where('status', 1);
            }, 'participant as all_participant']);
        $participants = TrainingParticipant::with(['user:id,name'])
            ->where('training_id', $training->id)
            ->where('status', 1)
            ->latest()
            ->get();
        return Inertia::render('Staff/Mytrainings/Show', [
            'training' => $training,
            'participants' => $participants,
        ]);
    }

    public function apply_training($id, Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:500'
        ]);
        $training = Training::findOrFail($id);
        if($training->status != 1)
            return back()->with('danger', 'Training is not Active');
        $training->load(['notice']);
        if($training->notice->notice_date > date('Y-m-d') && $training->submit_date < date('Y-m-d'))
            return back()->with('warning', 'Please Submit your application at '.$training->notice->notice_date.' - '.$training->notice->submit_date);

        if(TrainingParticipant::where('training_id', $training->id)->where('user_id', auth()->id())->first())
        {
            return back()->with('info', 'You have Already Applied For This Training');
        }
        TrainingParticipant::create([
            'training_id' => $training->id,
            'user_id' => auth()->id(),
            'status' => 0,
            'description' => $request->description
        ]);
        return back()->with('success', 'You Applied For This Training');
        
    }
    public function calendar(Request $request)
    {
        $trainings = Training::with(['program:id,title'])
            ->where('status', 1)
            ->whereDate('from', '>=', $request->start)
            ->whereDate('to', '<=', $request->end)
            ->get();
        $events = [];
        foreach($trainings as $training)
        {
            $events[] = [
                'id' => $training->id,
                'title' => ($training->program ? '['.$training->program->title.'] ': ''). $training->description,
                'start' => $training->from,
                'end' => $training->to,
            ];
        }
        return response($events);
    }

    public function getTraining($id)
    {
        $training = Training::with(['program:id,title', 'category'])->findOrFail($id);
        return $training;
    }

    public function evaluationForm($id)
    {
        $template = TrainingTemplate::findOrFail($id);
        $part = TrainingParticipant::where('training_id', $template->training_id)
                ->where('user_id', auth()->id())
                ->where('status', 1)
                ->first();
        if(!isset($part->id))
            return back()->with('success', 'This Evaluation Form is Not Shared With You');

        $questions = TrainingTemplateQuestion::where('training_template_id', $template->id)
                ->orderBy('order')
                ->get();
        return Inertia::render('Staff/Mytrainings/Evaluation', [
            'template' => $template,
            'questions' => $questions,
            'muti_answer' => config('trainingConstant.answer_options')
        ]);
    }

    public function saveEvaluationForm($id, Request $request)
    {
        $this->validate($request,[
            'myanswer.*' => 'required'
        ]);
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
                'staff_id' => auth()->id(),
                'answer_date' => Date('Y-m-d'),
                'score' => $ans['type'] == 'multiple' ? $ans['answer'] : 0,
            ];
        }
        TrainingTemplateQuestionAnswer::insert($answers);
        return redirect()->route('staffs.mytrainings.index', ['type'=>'evaluation'])->with('success', 'Form Submitted Successfully');
    }
    private function multipleChoiceAns($value)
    {
        $answers = config('trainingConstant.answer_options');
        $key = array_search($value, array_column($answers, 'value'));
        return $answers[$key]['title'];
    }
}
