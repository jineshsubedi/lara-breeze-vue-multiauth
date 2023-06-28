<?php

namespace Hris\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPlace extends Model
{
    use HasFactory;

    protected $fillable = array('id', 'title');
}
