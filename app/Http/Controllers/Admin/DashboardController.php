<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $datas['today'] = Carbon::today()->format('d F, Y');
        $attendance = new Attendance();
        $datas['attendances'] = $attendance->getTodayAttendance();
        // return $datas['attendances'];
        return Inertia::render('Admin/Dashboard', [
            'datas' => $datas
        ]);
    }
}
