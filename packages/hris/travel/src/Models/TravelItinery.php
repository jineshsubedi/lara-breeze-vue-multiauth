<?php

namespace Hris\Travel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelItinery extends Model
{
    use HasFactory;

    protected $fillable = array('travel_planner_id', 'date', 'travel_from', 'travel_to', 'time_from', 'time_to', 'description');
}
