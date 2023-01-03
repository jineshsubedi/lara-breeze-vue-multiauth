<?php 

namespace App\Traits;

use App\Models\User;
use Carbon\Carbon;
use Hris\Attendance\Models\Attendance;
use Hris\Event\Models\Event;
use Hris\Holiday\Models\Holiday;
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
}