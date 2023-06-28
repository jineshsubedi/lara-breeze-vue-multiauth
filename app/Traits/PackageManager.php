<?php 

namespace App\Traits;

use App\Models\DailyTask;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Hris\Attendance\Models\Attendance;
use Hris\Event\Models\Event;
use Hris\Holiday\Models\Holiday;
use Hris\Survey\Models\Survey;
use Hris\Survey\Models\SurveyAnswer;
use Hris\Task\Models\HelpDesk;
use Hris\Task\Models\Task;

trait PackageManager
{

    public function getTodayAttendance()
    {
        try {
            $attendance = new Attendance();
            return $attendance->getTodayAttendance();
        } catch (\Throwable $th) {
            //throw $th;
            return [];
        }
        
    }
    public function getHoliday($date)
    {
        try {
            $holiday = Holiday::where('branch_id', auth()->user()->branch_id)->whereDate('start_date', '<=', $date)->whereDate('end_date', '>=', $date)->first();
            return $holiday;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
        
    }
    public function getAllHolidays()
    {
        try {
            $datas = [];
            $holiday = Holiday::where('branch_id', auth()->user()->branch_id)->whereDate('start_date', '>=', Carbon::today()->subMonths(1)->format('Y-m-d'))->whereDate('end_date', '<=', Carbon::today()->format('Y-m-d'))->get();
            foreach($holiday as $h)
            {
                $startDate = Carbon::parse($h->start_date);
                $stopDate = Carbon::parse($h->end_date);
                for ($i=$startDate; $i <= $stopDate; $i->addDay()) { 
                    $datas[] = $i->format('Y-m-d');
                } 
            }
            return $datas;
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function getUserWeekendDays()
    {
        $datas = [];
        User::setWeekend();
        $startDate = Carbon::now()->subMonths(1);
        $stopDate = Carbon::now();
        for ($i=$startDate; $i < $stopDate; $i->addDay()) { 
            if ($i->isWeekend()===true) {
                $datas[] = $i->format('Y-m-d');
            }
        }
        return $datas;
    }
    public function getAllHolidaysWithTitle()
    {
        try {
            $datas = [];
            $holiday = Holiday::where('branch_id', auth()->user()->branch_id)->get();
            foreach($holiday as $h)
            {
                $datas[] = [
                    'title' => $h->title,
                    'start' => $h->start_date,
                    'end' => $h->end_date,
                ];
            }
            return $datas;
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function getAllEvents($start, $end)
    {
        try {
            return Event::whereJsonContains('branch', auth()->user()->branch_id)
            ->whereDate('start_date', '>=', $start)
            ->whereDate('end_date', '<=', $end)
            ->get(['id', 'title', 'start_date', 'end_date']);
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function getStaffTasks($id): Array
    {
        try {
            $tasks = Task::with(['kra:id,title', 'fromUser:id,name'])->where('task_to', $id)->latest()->limit(10)->get(['id', 'title', 'description', 'weightage', 'finish_time', 'complete_status', 'project', 'task_from','kra_id'])->toArray();
        } catch (\Throwable $th) {
            $tasks = [];
        }
        return count($tasks) > 0 ? $tasks : [];
    }
    public function getStaffHelpDesks($id): Array
    {
        try {
            $tasks = HelpDesk::with(['fromUser:id,name', 'kra:id,title'])->where('task_to', $id)->latest()->limit(10)->get(['id', 'title', 'task_from', 'start_time', 'finish_time', 'kra_id', 'complete_status'])->toArray();
        } catch (\Throwable $th) {
            $tasks = [];
        }
        return count($tasks) > 0 ? $tasks : [];
    }
    public function getStaffApprovedLeaves($id): Array
    {
        try {
            $leaves = Leave::with(['user:id,name','branch:id,name', 'leaveType:id,title'])->where('user_id', $id)->latest('id')->limit(10)->get(['id', 'user_id', 'leave_type_id', 'type', 'start_date', 'end_date', 'duration', 'paid', 's_approve', 'h_approve', 'm_approve'])->map(function($q){
                if($q->type == 1)
                    $q->type_label = 'Full';
                elseif($q->type == 2)
                    $q->type_label = 'Half';
                elseif($q->type == 3)
                    $q->type_label = 'Quarter';
                return $q;
            })->toArray();
        } catch (\Throwable $th) {
            $leaves = [];
        }
        return count($leaves) > 0 ? $leaves : [];
    }
    public function getStaffAttendances($id): Array
    {
        try {
            $attendances = Attendance::where('user_id', $id)->latest('id')->limit(30)->get(['id', 'attendance_date', 'in_time', 'in_location', 'out_time', 'out_location', 'approve'])->toArray();
        } catch (\Throwable $th) {
            $attendances = [];
        }
        return count($attendances) > 0 ? $attendances : [];
    }
    public function getStaffDynamicSurvey($id): Array 
    {
        try {
            $surveyIds = SurveyAnswer::where('user_id', $id)->groupBy('survey_id', 'user_id')->pluck('survey_id');
            $surveys = Survey::whereIn('id', $surveyIds)->where('status', 1)->latest('id')->limit(10)->get(['id', 'title', 'start_date', 'end_date', 'status'])->toArray();
        } catch (\Throwable $th) {
            $surveys = [];
        }
        return count($surveys) > 0 ? $surveys : [];
    }
    public function getTodayTask()
    {
        try {
            return DailyTask::where('user_id', auth()->id())
            ->whereDate('created_at', Date('Y-m-d'))
            ->orderBy('id', 'desc')
            ->get()->map(function($query){
                $query->duration = $query->calculate_duration;
                return $query;
            });
        } catch (\Throwable $th) {
           return [];
        }
    }
}