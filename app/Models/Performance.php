<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = array('user_id', 'comment_by', 'comment','comment_rating' );

    public static function checkPerformanceReport($period): bool
    {
        $day = Carbon::today()->day;
        if($period == 1 && $day > 23 && $day <= 28){
            $month = [1,2,3,4,5,6,7,8,9,10,11,12];
        }elseif($period == 2 && $day > 1 && $day <= 30){
            $month = [3,6,9,12];
        }elseif($period == 3 && $day > 26 && $day <= 30){
            $month = [6, 12];
        }elseif($period == 4 && $day > 26 && $day <= 31){
            $month = [12];
        }else{
            $month = [0];
        }
        $m = Carbon::today()->month;
        $m = 3;
        if(in_array($m, $month)){
            $quarter = Carbon::today()->format('Y-m');
            $staffs = User::where('supervisor_id', auth()->id())->where('status', User::CURRENTLY_WORKING)->count(); 
            $check = Performance::where('comment_by', auth()->id())->where('created_at', 'LIKE', '%'.$quarter.'%')->count();
            if($staffs <= $check){
                return false;
            }
            return true;
        }
        return false;
    }
}
