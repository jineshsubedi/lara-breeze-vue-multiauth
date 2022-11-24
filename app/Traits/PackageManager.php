<?php 

namespace App\Traits;

use Hris\Attendance\Models\Attendance;

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
}