<?php

namespace Hris\Travel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelHotelBooking extends Model
{
    use HasFactory;

    protected $fillable = array('travel_planner_id', 'departure_at', 'arrival_at', 'name', 'place_name', 'district', 'number', 'remark');
}
