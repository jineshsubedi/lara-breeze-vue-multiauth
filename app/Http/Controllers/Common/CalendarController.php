<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\DailyTask;
use App\Models\Notice;
use App\Models\User;
use App\Traits\PackageManager;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    use PackageManager;

    public function getEvents(Request $request)
    {
        $events = [];
        
        $users = User::active()->where('branch_id', auth()->user()->branch_id)->pluck('id');
        $tasks = DailyTask::with(['kra:id,title'])
            ->whereIn('user_id', $users)
            ->whereDate('start_time', '>=', $request->start)
            ->whereDate('end_time', '<=', $request->end)
            ->get(['id', 'kra_id', 'description', 'start_time', 'end_time']);
        
        foreach($tasks as $task)
        {
            $events[] = [
                'title' => ($task->kra ? '['.$task->kra->title.'] ': ''). $task->description,
                'start' => $task->start_time,
                'end' => $task->end_time,
            ];
        }
        $holidays = $this->getAllHolidaysWithTitle();
        if(count($holidays) > 0)
            $events = array_merge($events, $holidays);

        $month = Carbon::parse($request->start)->format('m');
        $year = Carbon::parse($request->start)->format('Y');
        $birthdays = User::active()
                ->where('branch_id', auth()->user()->branch_id)
                ->whereNotNull('dob')
                ->whereMonth('dob', '>=', $month)
                ->whereMonth('dob', '<=', $month + 1)
                ->get(['id', 'name', 'dob']);
        foreach($birthdays as $birth)
        {
            $bdate = $year.'-'.Carbon::parse($birth->dob)->format('m-d');
            $events[] = [
                'title' => '['.$birth->name.'] Birthday',
                'start' => $bdate,
                'end' => $bdate,
            ];
        }
        $anniversary = User::active()
                ->where('branch_id', auth()->user()->branch_id)
                ->whereNotNull('join_date')
                ->whereYear('join_date', '!=', $year)
                ->whereMonth('join_date', '>=', $month)
                ->whereMonth('join_date', '<=', $month + 1)
                ->get(['id', 'name', 'join_date']);
        foreach($anniversary as $ann)
        {
            $adate = $year.'-'.Carbon::parse($birth->join_date)->format('m-d');
            $events[] = [
                'title' => '['.$ann->name.'] Work Anniversary',
                'start' => $adate,
                'end' => $adate,
            ];
        }
        $notices = Notice::where('branch_id', auth()->user()->branch_id)
                ->whereDate('start_date', '>=', $request->start)
                ->whereDate('end_date', '<=', $request->end)
                ->get(['id', 'title', 'start_date', 'end_date']);
        foreach($notices as $notice)
        {
            $events[] = [
                'title' => '[Notice] '.$notice->title,
                'start' => $notice->start_date,
                'end' => $notice->end_date,
            ];
        }
        $eventss = $this->getAllEvents($request->start, $request->end);
        foreach($eventss as $event)
        {
            $events[] = [
                'title' => '[Event] '.$event->title,
                'start' => Carbon::parse($event->start_date)->format('Y-m-d'),
                'end' => Carbon::parse($event->end_date)->format('Y-m-d'),
            ];
        }
        return response($events);
    }
}
