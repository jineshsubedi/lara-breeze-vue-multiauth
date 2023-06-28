<?php

namespace Hris\Travel\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelPlanner extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'travel_id', 'staff_id', 'supervisor_approval', 'hr_approval', 'chairman_approval');

    protected $appends = ['supervisor_action', 'hr_action', 'chairman_action'];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function travel()
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }
    public function itinery()
    {
        return $this->hasMany(TravelItinery::class, 'travel_planner_id');
    }
    public function road()
    {
        return $this->hasMany(TravelRoad::class, 'travel_planner_id');
    }
    public function air()
    {
        return $this->hasMany(TravelAir::class, 'travel_planner_id');
    }
    public function hotel()
    {
        return $this->hasMany(TravelHotelBooking::class, 'travel_planner_id');
    }
    public function visa()
    {
        return $this->hasOne(TravelVisa::class, 'travel_planner_id');
    }
    public function supervisorAction(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLabel(0, $this->supervisor_approval)
        );
    }
    public function hrAction(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLabel($this->account_approval, $this->hr_approval)
        );
    }
    public function chairmanAction(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLabel($this->hr_approval, $this->chairman_approval)
        );
    }
    private function getStatusLabel($prev, $value)
    {
        if($prev == 2)
            return '<span class="badge bg-danger">Rejected</span>';
        if($value == 0)
            return '<span class="badge bg-secondary">Pending</span>';
        if($value == 1)
            return '<span class="badge bg-success">Approved</span>';
        if($value == 2)
            return '<span class="badge bg-danger">Rejected</span>';

        return '';
    }
}
