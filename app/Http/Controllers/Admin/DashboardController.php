<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PerformanceTitle;
use App\Http\Controllers\Controller;
use App\Models\BranchSetting;
use App\Traits\PackageManager;
use Illuminate\Http\Request;
use App\Models\DailyTask;
use App\Models\Performance;
use App\Models\PerformanceSetting;
use App\Models\SubordinateRating;
use App\Models\User;
use App\Models\UserKra;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use PackageManager;

    public function index(Request $request)
    {
        $datas['today'] = Carbon::today()->format('d F, Y');
        $datas['attendances'] = $this->getTodayAttendance();
        // return $datas;
        $datas['dailyTasks'] = $this->getTodayTask();
        $datas['kra'] = UserKra::where('user_id', auth()->id())->get(['id', 'title']);

        // Subordinate Rating
        $datas['subordinate_rating'] = $this->subordinateRating();
        $datas['performance_rating'] = $this->performanceRating();
        $datas['performance_staff'] = $this->performanceStaff();
        return Inertia::render('Admin/Dashboard', [
            'datas' => $datas
        ]);
    }
    public function subordinateRating(): bool
    {
        $checkPerformance = PerformanceSetting::where('branch_id', auth()->user()->branch_id)->where('title', PerformanceTitle::SUBORDINATE_RATING->value)->where('parameter','>','0')->first();
        $sup_check = 1;
        if(isset($checkPerformance->id))
        {
            $parameter = $checkPerformance->duration;
            switch ($parameter) {
                case 2:
                    $day = date('d');
                    if($day > 13 && $day < 17)
                    {
                        $sup_check = SubordinateRating::where('supervisor_id', auth()->user()->supervisor_id)->where('user_id', auth()->id())->where('created_at', 'LIKE', date('Y-m').'%')->count();
                    }
                    break;
                case 3:
                    $day = date('d');
                    if($day > 2 && $day < 32)
                    {
                        $sup_check = SubordinateRating::where('supervisor_id', auth()->user()->supervisor_id)->where('user_id', auth()->id())->where('created_at', 'LIKE', date('Y-m').'%')->count();
                    }
                    break;
                case 4:
                    $months = ['3','6','9','12'];
                    $m = date('m');
                    if(in_array($m,$months)){
                        $day = date('d');
                        if($day > 23 && $day < 32){
                            $sup_check = SubordinateRating::where('supervisor_id', auth()->user()->supervisor_id)->where('user_id', auth()->id())->where('created_at', 'LIKE', date('Y-m').'%')->count();
                        }
                    }   
                    break;   
                case 5:
                    $months = ['6','12'];
                    $m = date('m');
                    if(in_array($m,$months)){
                        $sup_check = SubordinateRating::where('supervisor_id', auth()->user()->supervisor_id)->where('user_id', auth()->id())->where('created_at', 'LIKE', date('Y-m').'%')->count();
                    }
                    break;
                case 6:
                    $day = date('d');
                    $month = date('m');
                    if($month == 12 && $day > 26 && $day < 31)
                    {
                        $sup_check = SubordinateRating::where('supervisor_id', auth()->user()->supervisor_id)->where('user_id', auth()->id())->where('created_at', 'LIKE', date('Y-m').'%')->count();
                    }
                default:
                    $sup_check = 0;
                    break;
            }
        }
        return ($sup_check == 0 ? true : false);
    }
    public function performanceRating(): bool
    {
        $checkRatingTime = BranchSetting::select('performance_rating_type')->where('branch_id', auth()->user()->branch_id)->first();
        return Performance::checkPerformanceReport($checkRatingTime->performance_rating_type ?? 0);
    }
    public function performanceStaff()
    {
        $quarter = Carbon::today()->format('Y-m');
        $stf = [];
        $staffs = User::select('id','name')->where('supervisor_id', auth()->user()->id)->where('status', User::CURRENTLY_WORKING)->orderBy('name','asc')->get();
        foreach($staffs as $stif)
        {
            $check = Performance::where('user_id', $stif->id)->where('comment_by',auth()->user()->id)->where('created_at', 'LIKE', '%'.$quarter.'%')->get();

            if(count($check) < 1)
            {
                $stf[] = ['id' => $stif->id, 'name' => $stif->name];
            }
        }
        return $stf;
    }
}
