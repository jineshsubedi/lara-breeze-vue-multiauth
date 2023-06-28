<?php

namespace Hris\Travel\Models;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelVisa extends Model
{
    use HasFactory;

    protected $fillable = array('travel_planner_id', 'department_id', 'user_id');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
