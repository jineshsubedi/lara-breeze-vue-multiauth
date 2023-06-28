<?php

namespace Hris\Travel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelRoad extends Model
{
    use HasFactory;

    protected $fillable = array('travel_planner_id', 'vehicle_number', 'driver_name', 'driver_number', 'vendor_name', 'bus_number');
}
