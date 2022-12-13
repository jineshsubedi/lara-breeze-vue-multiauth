<?php

namespace Hris\Attendance\Models;

use App\Models\BranchSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Attendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'branch_id',
        'attendance_date',
        'in_time',
        'out_time',
        'lunch_start',
        'lunch_end',
        'in_location',
        'out_location',
        'lunch_start_location',
        'lunch_end_location',
        'np_year',
        'np_month',
        'np_date',
        'approve',
        'manual',
        'in_time_reason',
        'out_time_reason',
        'in_away_location',
        'out_away_location',
        'remarks'
    ];

    protected $appends = ['attendance_duration', 'approve_title', 'in_time_class', 'out_time_class', 'lunch_start_class', 'lunch_end_class', 'in_time_distance', 'out_time_distance', 'lunch_start_distance', 'lunch_end_distance', 'attendance_duration', 'en_year'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStaffNameAttribute(): string
    {
        return $this->user->name;
    }
    public function getTodayAttendance()
    {
        $attendances = self::where('user_id', auth()->user()->id)->where('attendance_date', date('Y-m-d'))->orderBy('id', 'desc')->get();
        $primary = auth()->user()->address ? auth()->user()->address->primary_location : '27.6660224, 85.377024';
        if (count($attendances) > 0) {
            foreach ($attendances as $attendance) {
                $datas[] = [
                    'in_time' => $attendance->in_time,
                    'lunch_start' => $attendance->lunch_start,
                    'lunch_end' => $attendance->lunch_end,
                    'out_time' => $attendance->out_time,

                    'in_time_distance' => $attendance->in_time_distance,
                    'lunch_start_distance' => $attendance->lunch_start_distance,
                    'lunch_end_distance' => $attendance->lunch_end_distance,
                    'out_time_distance' => $attendance->out_time_distance,
                    'in_time_class' => $attendance->in_time_class,
                    'lunch_start_class' => $attendance->lunch_start_class,
                    'lunch_end_class' => $attendance->lunch_end_class,
                    'out_time_class' => $attendance->out_time_class,

                    'in_away_location' => $attendance->in_away_location == null ? true : false,
                    'out_away_location' => $attendance->out_away_location == null ? true : false,
                    'attendance_id' => isset($attendance->id) ? $attendance->id : '',
                    'in_location' => $attendance->in_location,
                    'out_location' => $attendance->out_location,
                    'lunch_start_location' => $attendance->lunch_start_location,
                    'lunch_end_location' => $attendance->lunch_end_location,
                ];
            }
        } else{
            $datas[] = [
                'in_time' => null,
                'lunch_start' => null,
                'lunch_end' => null,
                'out_time' => null,
                'in_time_distance' => '',
                'lunch_start_distance' => '',
                'lunch_end_distance' => '',
                'out_time_distance' => '',
                'in_time_class' => '',
                'lunch_start_class' => '',
                'lunch_end_class' => '',
                'out_time_class' => '',
                'in_away_location' => false,
                'out_away_location' => false,
                'attendance_id' => '',
                'in_location' => null,
                'out_location' => null,
                'lunch_start_location' => null,
                'lunch_end_location' => null,
            ];
        }
        return $datas;
    }
    public function getDistance($lat1 = '', $lon1 = '', $lat2 = '', $lon2 = '', $unit = '')
    {

        if ($lat1 != '' && $lon1 != '' && $lat2 != '' && $lon2 != '' && $unit != '') {
            if (is_numeric($lat1) && is_numeric($lat2) && is_numeric($lon1) && is_numeric($lon2)) {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $unit = strtoupper($unit);

                if ($unit == "K") {
                    return ($miles * 1.609344);
                } else if ($unit == "N") {
                    return ($miles * 0.8684);
                } else {
                    return $miles;
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    public function attendanceDuration(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getDuration(
                $this->attendance_date,
                $this->in_time,
                $this->out_time,
                $this->lunch_start,
                $this->lunch_end,
            ),
        );
    }
    public function getDuration($attendance_date, $in_time, $out_time, $lunch_start, $lunch_end)
    {
        $from1 = Carbon::parse($attendance_date . ' ' . $in_time);
        $to1 = Carbon::parse($attendance_date . ' ' . $lunch_start);

        $from2 = Carbon::parse($attendance_date . ' ' . $lunch_end);
        $to2 = Carbon::parse($attendance_date . ' ' . $out_time);

        $minutes1 = 0;
        $minutes2 = 0;
        $total_minute = 0;
        $human_time = '';
        if ($out_time != '') {
            if ($lunch_start != '') {
                $minutes1 = $to1->diffInMinutes($from1);
            }
            if ($lunch_end != '' && $out_time != '') {
                $minutes2 = $to2->diffInMinutes($from2);
            }

            $total_minute = $minutes1 + $minutes2;

            if ($lunch_start == '' && $out_time != '') {
                $total_minute = $to2->diffInMinutes($from1);
            }

            if ($total_minute != 0) {
                if ($total_minute > 60) {
                    $hour = floor($total_minute / 60);
                    $minute = $total_minute - ($hour * 60);
                    $human_time = $hour . ' Hour ' . $minute . ' Minutes';
                } else {
                    $human_time = $total_minute . 'Minutes';
                }
            }
        }
        return $human_time;
    }
    public function approveTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getApproveSpan($this->approve),
        );
    }
    public function getApproveSpan($value): String
    {
        $title = '';
        switch($value){
            case 1:
                $title = '<span class="badge bg-success">Approved</span>';
                break;
            case 2:
                $title = '<span class="badge bg-danger">Rejected</span>';
                break;
            default:
                $title = '<span class="badge bg-warning">Pending</span>';
        }
        return $title;
    }
    public function inTimeClass(): Attribute 
    {
        return Attribute::make(
            get: fn () => $this->in_time != '' ? $this->generateClass($this->in_location) : '',
        );
    }
    public function outTimeClass(): Attribute 
    {
        return Attribute::make(
            get: fn () => $this->out_time != '' ? $this->generateClass($this->out_location) : '',
        );
    }
    public function lunchStartClass(): Attribute 
    {
        return Attribute::make(
            get: fn () => $this->lunch_start != '' ? $this->generateClass($this->lunch_start_location) : '',
        );
    }
    public function lunchEndClass(): Attribute 
    {
        return Attribute::make(
            get: fn () => $this->lunch_end != '' ? $this->generateClass($this->lunch_end_location) : '',
        );
    }
    public function inTimeDistance(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->in_time != '' ? $this->generateDistanceClass($this->in_location) : '',
        );
    }
    public function outTimeDistance(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->out_time != '' ? $this->generateDistanceClass($this->out_location) : '',
        );
    }
    public function lunchStartDistance(): Attribute 
    {
        return Attribute::make(
            get: fn () => $this->lunch_start != '' ? $this->generateDistanceClass($this->lunch_start_location) : '',
        );
    }
    public function lunchEndDistance(): Attribute 
    {
        return Attribute::make(
            get: fn () => $this->lunch_end != '' ? $this->generateDistanceClass($this->lunch_end_location) : '',
        );
    }
    private function generateClass($location)
    {
        $primary_location = auth()->user()->address->primary_location ? auth()->user()->address->primary_location : '27.6660224, 85.377024';
        $primary = array_map('trim', explode(',', $primary_location));
        $mylocation = array_map('trim', explode(',', $location));
        $distance = $this->getDistance($primary[0], $primary[1], $mylocation[0], $mylocation[1], 'K');
        if ($distance > '0.3') {
            $class = 'badge bg-danger';
        } else {
            $class = 'badge bg-success';
        }
        return $class;
    } 
    private function generateDistanceClass($location)
    {
        $primary_location = auth()->user()->address->primary_location ? auth()->user()->address->primary_location : '27.6660224, 85.377024';
        $primary = array_map('trim', explode(',', $primary_location));
        $mylocation = array_map('trim', explode(',', $location));
        $distance = $this->getDistance($primary[0], $primary[1], $mylocation[0], $mylocation[1], 'K');
        
        return number_format((float)$distance, 2, '.', '') . ' KM';
    } 
    public function generateDistance($location)
    {
        $primary_location = auth()->user()->address->primary_location ? auth()->user()->address->primary_location : '27.6660224, 85.377024';
        $primary = array_map('trim', explode(',', $primary_location));
        $mylocation = array_map('trim', explode(',', $location));
        $distance = $this->getDistance($primary[0], $primary[1], $mylocation[0], $mylocation[1], 'K');
        if ((float)$distance > 0.3) {
            return true;
        } else {
            return false;
        }
    } 
    public function enYear(): Attribute 
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->created_at)->format('Y'),
        );
    }
}
