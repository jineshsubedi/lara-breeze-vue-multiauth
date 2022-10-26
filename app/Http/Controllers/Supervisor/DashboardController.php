<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\DailyTask;
use App\Models\UserKra;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $datas['today'] = Carbon::today()->format('d F, Y');
        $attendance = new Attendance();
        $datas['attendances'] = $attendance->getTodayAttendance();

        $datas['dailyTasks'] = DailyTask::where('user_id', auth()->id())
            ->whereDate('created_at', Date('Y-m-d'))
            ->orderBy('id', 'desc')
            ->get()->map(function($query){
                $query->duration = $query->calculate_duration;
                return $query;
            });
        $datas['kra'] = UserKra::where('user_id', auth()->id())->get(['id', 'title']);

        return Inertia::render('Supervisor/Dashboard', [
            'datas' => $datas
        ]);
    }
}
