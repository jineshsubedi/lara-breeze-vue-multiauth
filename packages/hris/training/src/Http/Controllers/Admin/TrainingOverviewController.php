<?php

namespace Hris\Training\Http\Controllers\Admin;

use App\Enums\StaffType;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Hris\Training\Models\Training;
use Hris\Training\Models\TrainingCost;
use Hris\Training\Models\TrainingItinery;
use Hris\Training\Models\TrainingParticipant;
use Hris\Training\Models\TrainingProgram;
use Hris\Training\Models\TrainingTemplate;
use Hris\Training\Models\TrainingTemplateQuestion;
use Hris\Training\Models\TrainingTemplateQuestionAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainingOverviewController extends Controller
{
    public function index()
    {
        $overtime = $expenditure = $template = [];
        $query = $this->filterQuery();

        if(request()->type == 'evaluation') {
            $trainingIds = $query->pluck('trainings.id');
            $templateIds = TrainingTemplate::whereIn('training_id', $trainingIds)->where('schedule', 1)->pluck('id');
            $template['total_training'] = count($trainingIds);
            $template['total_template'] = count($templateIds);
            $template['full_score'] = TrainingTemplateQuestion::whereIn('training_template_id', $templateIds)->where('type', 'multiple')->count() * 5;
            $template['total_score'] = TrainingTemplateQuestionAnswer::whereIn('training_id', $trainingIds)->sum('score');

            $template['templateScoreChart'] = $this->templateScoreChart($templateIds);
            $template['share_both_chart'] = $this->shareBothChart($trainingIds);
            $template['share_trainee_chart'] = $this->shareTraineeChart($trainingIds);
            $template['share_trainer_chart'] = $this->shareTrainerChart($trainingIds);
        }
        else if(request()->type == 'cost') {
            $expenditure['total_training'] = $query->count();
            $expenditure['total_budget'] = $query->sum('budget');
            $expenditure['trainee_cost'] = $query
                ->leftJoin('training_costs', function($join){
                    $join->on('trainings.id','=','training_costs.training_id');
                })
                ->sum('training_costs.total_cost');

            $expenditure['total_hour'] = $query
                ->leftJoin('training_itineries', function($join){
                    $join->on('trainings.id','=','training_itineries.training_id');
                })
                ->sum('training_itineries.duration');
            
            $expenditure['trainer_cost'] = $this->trainerCost($query);
            $expenditure['costItemStat'] = $this->costItemStat($query);
            
        }
        else{
            $overtime['trainingStaffByDepartment'] = $this->trainingSaffByDepartment($query);
            $overtime['programVsTraining'] = $this->programVsTraining();

            $overtime['trainingVsParticipant'] = $this->trainingVsParticipant($query);
            
            $overtime['total_training'] = $query->count();
            $overtime['total_invited'] = $query->sum('total_participant');

            $overtime['total_hour'] = $query
                ->leftJoin('training_itineries', function($join){
                    $join->on('trainings.id','=','training_itineries.training_id');
                })
                ->sum('training_itineries.duration');
    
            $overtime['total_cost'] = $query->sum('budget');
                
            $overtime['total_trained'] = $query
                ->leftJoin('training_participants', function($join){
                    $join->on('trainings.id','=','training_participants.training_id');
                })
                ->where('training_participants.status', 1)
                ->count();
        }
        return Inertia::render('Admin/TrainingOverview/Index',[
            'overtime' => $overtime,
            'expenditure' => $expenditure,
            'template' => $template,
            'branches' => Branch::branchList(),
            'years' => Training::getYear(),
            'programs' => TrainingProgram::orderBy('title')->get(['id','title']),
            'filters' => request()->only(['type', 'program', 'from', 'to', 'year', 'branch'])
        ]);
    }
    private function templateScoreChart($templateIds)
    {
        $result = [];
        foreach($templateIds as $tid)
        {
            $template = TrainingTemplateQuestionAnswer::where('training_template_id', $tid)->where('score', '>', 0)->get();
            if($template->isNotEmpty()){
                $result[] = [
                    $template->count() * 5,
                    $template->sum('score')
                ];
            }
        }
        $keys = array_column($result, 1);
        array_multisort($keys, SORT_DESC, $result);
        array_slice($result,0,10);
        return array_values($result);
    }
    private function shareBothChart($trainingIds)
    {
        $result = [];
        $templateIds = TrainingTemplate::whereIn('training_id', $trainingIds)->where('schedule', 1)->where('share_with', 0)->get(['id', 'title', 'training_id', 'schedule', 'share_with']);
        foreach($templateIds as $tid)
        {
            $templateAns = TrainingTemplateQuestionAnswer::where('training_template_id', $tid->id)
                ->where('score', '>', 0)
                ->get();
            if($templateAns->isNotEmpty()){
                $result[] = [
                    $tid->title,
                    $templateAns->count() * 5,
                    $templateAns->sum('score')
                ];
            }
        }
        $keys = array_column($result, 1);
        array_multisort($keys, SORT_DESC, $result);
        array_slice($result,0,10);
        return array_values($result);
    }
    private function shareTraineeChart($trainingIds)
    {
        $result = [];
        $templateIds = TrainingTemplate::whereIn('training_id', $trainingIds)->where('schedule', 1)->where('share_with', 2)->get(['id', 'title', 'training_id', 'schedule', 'share_with']);
        foreach($templateIds as $tid)
        {
            $templateAns = TrainingTemplateQuestionAnswer::where('training_template_id', $tid->id)
                ->where('score', '>', 0)
                ->get();
            if($templateAns->isNotEmpty()){
                $result[] = [
                    $tid->title,
                    $templateAns->count() * 5,
                    $templateAns->sum('score')
                ];
            }
        }
        $keys = array_column($result, 1);
        array_multisort($keys, SORT_DESC, $result);
        array_slice($result,0,10);
        return array_values($result);
    }
    private function shareTrainerChart($trainingIds)
    {
        $result = [];
        $templateIds = TrainingTemplate::whereIn('training_id', $trainingIds)->where('schedule', 1)->where('share_with', 1)->get(['id', 'title', 'training_id', 'schedule', 'share_with']);
        foreach($templateIds as $tid)
        {
            $templateAns = TrainingTemplateQuestionAnswer::where('training_template_id', $tid->id)
                ->where('score', '>', 0)
                ->get();
            if($templateAns->isNotEmpty()){
                $result[] = [
                    $tid->title,
                    $templateAns->count() * 5,
                    $templateAns->sum('score')
                ];
            }
        }
        $keys = array_column($result, 1);
        array_multisort($keys, SORT_DESC, $result);
        array_slice($result,0,10);
        return array_values($result);
    }

    private function costItemStat($training)
    {
        $trainingIds = $training->pluck('trainings.id');
        $costs = TrainingCost::whereIn('training_id', $trainingIds)->get();
        $result = array_reduce($costs->toArray(), function($carry, $item){
            $carry[$item['title']] = $carry[$item['title']] ?? 0;
            $carry[$item['title']] += $item['total_cost'];
            return $carry;
        },[]);
        arsort($result);
        $result = array_slice($result,0,10);
        return array_map(function($title, $cost){ return [$title, $cost];}, array_keys($result), $result);
    }
    private function trainerCost($training)
    {
        $ttrainer = $training->with(['trainer', 'category'])->get();
        return $ttrainer->sum(function($train) {
            if($train->trainer->charge_type == 1) {
                return $train->trainer->rate * $train->category->sum('duration');
            }
            return $train->trainer->rate;
        });
    }

    private function trainingVsParticipant($training)
    {
        $trainings = $training->withCount(['participant' => function($q){
            $q->where('status', 1);
        }])->with(['program:id,title', 'category:id,training_id,duration'])->get();
        $result = $trainings->map(function($training) {
            return [
                $training->program->title,
                $training->total_participant,
                $training->participant_count,
                $training->category->sum('duration'),
            ];
        });
        $result = $result->sortByDesc(function($item) {
            return $item[1];
        });
        return $result->take(10)->values()->toArray();
    }
    private function programVsTraining()
    {
        $programs = TrainingProgram::select(['id', 'title'])->orderBy('title')->get();
        $result = $programs->map(function($program) {
            $pcount = $this->filterQuery()->where('training_program_id', $program->id)->count();
            return [$program->title, $pcount];
        });
        $result = $result->sortByDesc(function($item) {
            return $item[1];
        });
        return $result->take(10)->values()->toArray();
    }
    private function trainingSaffByDepartment($training)
    {
        $trainingIds = $training->pluck('id');
        $is_admin = auth()->user()->roles->where('name', 'SuperAdmin')->first(); 
        $query = Department::select(['id', 'title']);
        if(!$is_admin)
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }
        $departments = $query->get();
        $deptStaff = $departments->map(function($department) use ($trainingIds) {
            $staffs = User::active()->where('department_id', $department->id)->pluck('id');
            $tcount = TrainingParticipant::where('status', 1)->whereIn('training_id', $trainingIds)->whereIn('user_id', $staffs)->count();
            return [$department->title, $tcount];
        });
        $deptStaff = $deptStaff->sortByDesc(function($item) {
            return $item[1];
        });
        return $deptStaff->take(10)->values()->toArray();
    }

    public function filterQuery()
    {
        $query = Training::query();
        $query->where('trainings.status', 1)->whereYear('trainings.created_at', request()->year ?? Date('Y'));
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('trainings.branch_id', auth()->user()->branch_id);
        }else{
            $query->when(request()->filled('branch'), function($query) {
                return $query->where('trainings.branch_id', request()->branch);
            });
        }
        $query->when(request()->filled('program'), function($query) {
            return $query->where('trainings.training_program_id', request()->program);
        });
        $query->when(request()->filled('from'), function($query) {
            return $query->where('trainings.from', '>=', request()->from);
        });
        $query->when(request()->filled('to'), function($query) {
            return $query->where('trainings.to', '<=', request()->to);
        });
        return $query;
    }
}
