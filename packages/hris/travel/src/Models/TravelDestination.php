<?php

namespace Hris\Travel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelDestination extends Model
{
    use HasFactory;

    protected $fillable = array('travel_id', 'from', 'to', 'departure_date', 'arrival_date');
}
