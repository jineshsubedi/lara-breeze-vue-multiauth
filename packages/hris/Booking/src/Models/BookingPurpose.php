<?php

namespace Hris\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPurpose extends Model
{
    use HasFactory;

    protected $table = 'booking_purpose';  

    protected $fillable = array('id','title');
}
