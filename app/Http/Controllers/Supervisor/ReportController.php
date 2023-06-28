<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\DailyTask;
use App\Models\KpiRating;
use App\Models\User;
use App\Models\UserKpi;
use App\Models\UserKra;
use App\Traits\PackageManager;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    use PackageManager;

    public function index($id)
    {
        $owner = false;
        if($id == auth()->id())
            $owner = true;
        $user = User::findOrFail($id);
        $user->avatarpath = $user->avatar_path;
        $user->nature_of_employment = $user->employment_nature;
        $user->load(
            [
                'documents:id,user_id,title,document',
                'address' => function($q){
                    $q->with(['pdistrict','tdistrict']);
                },
                'detail',
                'bank:id,user_id,account_number,bank_name,pf,pan_number', 
                'leducation' => function($q){
                    $q->with(['education:id,title', 'faculty:id,title']);
                }, 
                'department:id,title',
                'designation:id,title',
                'shiftTime:id,title,start_time,end_time',
                'supervisor:id,name'
            ]);
        $user->documents->map(function($query){
            $query->document_path = $query->document_path;
            return $query;
        });
        $kpis = $kras = $tasks = $helpdesks = $leaves = $attendances = $surveys = [];

        if(request()->filled('type')) {
            $kpis = request()->type == 'kpis' ? $this->getUserKpi($id) : [];
            $kras = request()->type == 'kras' ? $this->getUserKra($id) : [];
            $tasks = request()->type == 'tasks' ? $this->getStaffTasks($id) : [];
            $helpdesks = request()->type == 'helpdesks' ? $this->getStaffHelpDesks($id) : [];
            $leaves = request()->type == 'leaves' ? $this->getStaffApprovedLeaves($id) : [];
            $attendances = request()->type == 'attendances' ? $this->getStaffAttendances($id) : [];
            $surveys = request()->type == 'surveys' ? $this->getStaffDynamicSurvey($id) : [];
        }
        return Inertia::render('Supervisor/Reports/Index', [
            'user' => $user,
            'owner' => $owner,
            'kpis' => $kpis,
            'kras' => $kras,
            'tasks' => $tasks,
            'helpdesks' => $helpdesks,
            'attendances' => $attendances,
            'leaves' => $leaves,
            'surveys' => $surveys,
            'filters' => request()->only(['type'])
        ]);
    }

    private function getUserKpi($id): Array
    {
        $kpis = UserKpi::where('user_id', $id)->orderBy('title')->get()->map(function($query){
            $query->first_quearter = KpiRating::getRating($query->id, date('Y').'-03');
            $query->second_quearter = KpiRating::getRating($query->id, date('Y').'-06');
            $query->third_quearter = KpiRating::getRating($query->id, date('Y').'-09');
            $query->fourth_quearter = KpiRating::getRating($query->id, date('Y').'-012');
            return $query;
        })->toArray();
        return count($kpis) > 0 ? $kpis : [];
    }
    
    private function getUserKra($id): Array
    {
        $kras = UserKra::where('user_id', $id)->orderBy('title')->get()->toArray();
        return count($kras) > 0 ? $kras : [];
    }

    public function calendar($id, Request $request)
    {
        $tasks = DailyTask::with(['kra:id,title'])
            ->where('user_id', $id)
            ->whereDate('start_time', '>=', $request->start)
            ->whereDate('end_time', '<=', $request->end)
            ->get(['id', 'kra_id', 'description', 'start_time', 'end_time']);
        $events = [];
        foreach($tasks as $task)
        {
            $events[] = [
                'title' => ($task->kra ? '['.$task->kra->title.'] ': ''). $task->description,
                'start' => $task->start_time,
                'end' => $task->end_time,
            ];
        }
        return response($events);
    }
}
