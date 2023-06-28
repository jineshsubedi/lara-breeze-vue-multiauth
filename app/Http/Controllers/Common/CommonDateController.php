<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Library\NepaliDateApi;
use Carbon\Carbon;
use Hris\Attendance\Models\Attendance;
use Illuminate\Http\Request;

class CommonDateController extends Controller
{
    use NepaliDateApi;

    public function getYear(Request $request)
    {
        $type = $request->type;
        if(!in_array($request->type, [1,2]))
        {
            $type = 2;
        }
        try {
            if($type == 1)
            {
                $years = Attendance::get()->pluck('np_year')->unique();
                if(count($years) < 1)
                    $years[] = $this->getDefaultNepaliYearFromEnglishYear();
            }else{
                $years = Attendance::get()->pluck('en_year')->unique();
                if(count($years) < 1)
                    $years[] = Date('Y');
            }
        } catch (\Exception $th) {
            
        }
        
        return response()->json($years);
    }
    public function getMonth(Request $request)
    {
        $type = $request->type;
        if(!in_array($request->type, [1,2]))
        {
            $type = 2;
        }
        if ($type == 1) {
            for ($i=1; $i < 13; $i++) { 
                $months[] = [
                    'value' => $i,
                    'title' => $this->get_nepali_month($i)
                ];
            }
        } else{
            for ($i=1; $i < 13; $i++) { 
                $months[] = [
                    'value' => $i,
                    'title' => $this->get_english_month($i)
                ];
            }
        }
        return response()->json($months);
    }
    public function getDays(Request $request)
    {
        $type = $request->type;
        if(!in_array($request->type, [1,2]))
        {
            $type = 2;
        }
        if($type == 1){
            $npyr = $this->bsd[$request->year];
            $number_days = $npyr[$request->month];
        }else{
            $lastdate = Carbon::create($request->year,$request->month,1)->endOfMonth();
            $number_days = $lastdate->day;
        }
        $days = [];
        for($i=1;$i<=$number_days;$i++)
        {
            $days[] = $i;
        }
        return response()->json($days);
    }
}
