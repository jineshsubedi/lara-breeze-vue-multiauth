<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStaffNameAttribute(): string
    {
        $user = User::find($this->user_id);
        return $user->name ?: '';
    }
    public function getTodayAttendance()
    {
        $attendances = self::where('user_id', auth()->user()->id)->where('attendance_date', date('Y-m-d'))->orderBy('id', 'desc')->get();
        $primary = ['27.6660224', '85.377024'];
        // if (isset(auth()->user()->address()->primary_location)) {
        //     $primary = explode(',', auth()->user()->address()->primary_location);
        // }
        if (count($attendances) > 0) {
            foreach ($attendances as $attendance) {
                $in_distance = null;
                $in_location = null;
                $in_class = null;
                $in_time = null;
                $out_time = null;
                $out_distance = null;
                $out_location = null;
                $out_class = null;

                if ($attendance->in_time != '') {

                    $in_time = $attendance->in_time;
                    $inlocation = explode(',', $attendance->in_location);

                    $primarylat = '';
                    $primarylong = '';

                    if (isset($primary[0])) {
                        $primarylat = $primary[0];
                    }
                    if (isset($primary[1])) {
                        $primarylong = $primary[1];
                    }

                    $distance = $this->getDistance($primarylat, $primarylong, $inlocation[0], $inlocation[1], 'K');
                    if ($distance > '0.3') {
                        $class = 'text-danger';
                    } else {
                        $class = 'text-success';
                    }
                    $indis = '';
                    if ($distance != '') {
                        $indis = number_format($distance, 2, '.', '') . ' KM';
                    }

                    $in_distance = $indis;
                    $in_location = $attendance->in_location;
                    $in_class = $class;
                }

                if ($attendance->out_time != '') {
                    $out_time = $attendance->out_time;
                    $outlocation = explode(',', $attendance->out_location);
                    $primarylat = '';
                    $primarylong = '';
                    if (isset($primary[0])) {
                        $primarylat = $primary[0];
                    }
                    if (isset($primary[1])) {
                        $primarylong = $primary[1];
                    }

                    $odistance = $this->getDistance($primarylat, $primarylong, $outlocation[0], $outlocation[1], 'K');
                    if ($odistance > '0.3') {
                        $out_class = 'text-danger';
                    } else {
                        $out_class = 'text-success';
                    }
                    $outdis = $odistance;

                    if ($outdis != '') {
                        $outdis = number_format($outdis, 2, '.', '') . ' KM';
                    }

                    $out_distance = $outdis;
                    $out_location = $attendance->out_location;
                    $out_class = $out_class;
                }
                $in_away_location = false;
                $out_away_location = false;
                $attendance_id = isset($attendance->id) ? $attendance->id : '';
                $lunch_start = null;
                $lunch_start_location = null;
                $lunch_end = null;
                $lunch_end_location = null;

                if ($in_class == 'bg-danger' && $attendance->in_away_location == null) {
                    $in_away_location = true;
                }
                if ($out_class == 'bg-danger' && $attendance->out_away_location == null) {
                    $out_away_location = true;
                }

                if ($attendance->lunch_start != '') {

                    $lunch_start = $attendance->lunch_start;
                    $lunch_start_location = $attendance->lunch_start_location;

                }
                if ($attendance->lunch_end != '') {
                    $lunch_end = $attendance->lunch_end;
                    $lunch_end_location = $attendance->lunch_end_location;
                }
                $datas[] = [
                    'in_time' => $in_time,
                    'lunch_start' => $lunch_start,
                    'lunch_end' => $lunch_end,
                    'out_time' => $out_time,

                    'in_distance' => $in_distance,
                    'out_distance' => $out_distance,
                    'in_class' => $in_class,
                    'out_class' => $out_class,

                    'in_away_location' => $in_away_location,
                    'out_away_location' => $out_away_location,
                    'attendance_id' => $attendance_id,
                    'in_location' => $in_location,
                    'out_location' => $out_location,
                    'lunch_start_location' => $lunch_start_location,
                    'lunch_end_location' => $lunch_end_location,
                ];

            }

        } else{
            $datas[] = [
                'in_time' => null,
                'lunch_start' => null,
                'lunch_end' => null,
                'out_time' => null,

                'in_distance' => '',
                'out_distance' => '',
                'in_class' => '',
                'out_class' => '',

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
    public function getAttendanceDurationAttribute():string
    {
        return $this->getDuration(
            $this->attendance_date,
            $this->in_time,
            $this->out_time,
            $this->lunch_start,
            $this->lunch_end,
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
    public function getApproveTitleAttribute()
    {
        $title = '';
        switch($this->approve){
            case 1:
                $title = 'Approved';
                break;
            case 2:
                $title = 'Rejected';
                break;
            default:
                $title = 'UnApproved';
        }
        return $title;
    }
    public function getApproveSpanAttribute()
    {
        $title = '';
        switch($this->approve){
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
}
