<?php 

namespace App\Traits;

use Hris\Attendance\Models\Attendance;
use Hris\Holiday\Models\Holiday;

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
}