<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'en_year',
        'np_year',
        'np_month',
        'np_day',
        'en_month',
        'en_day',
        'start_time',
        'end_time',
        'description',
        'kra_id',
        'task_id',
        'status',
        'duration',
        'estimated_duration',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function kra()
    {
        return $this->belongsTo(UserKra::class, 'kra_id');
    }
    public function getCalculateDurationAttribute()
    {
        if($this->start_time && $this->end_time)
        {
            $startTime = Carbon::parse($this->start_time);
            $endTime = Carbon::parse($this->end_time);

            $hour =  $startTime->diff($endTime)->format('%H')." Hour";
            $minute =  $startTime->diff($endTime)->format('%I')." Minute";
            return $hour.'-'.$minute;
        }
        if($this->start_time && !$this->end_time)
        {
            return '- Minute';
        }
    }
    public function getCalculateEdurationAttribute()
    {
        $eduration = Carbon::parse($this->estimated_duration*60);
        $hour = $eduration->format('H');
        $minute = $eduration->format('i');
        return $hour.' Hour -'.$minute.' Minute';
    }
    public function getStatusTitleAttribute()
    {
        return $this->status == 1 ? 'Approved' : 'Pending';
    }
}
