<?php

namespace Hris\Travel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelAir extends Model
{
    use HasFactory;

    protected $fillable = array('travel_planner_id', 'airline_name', 'flight_number', 'departure_on', 'arrival_on');
}
