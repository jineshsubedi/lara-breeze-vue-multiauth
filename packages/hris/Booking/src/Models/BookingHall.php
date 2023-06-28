<?php

namespace Hris\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHall extends Model
{
    use HasFactory;

    protected $fillable = array('booking_place_id', 'title');

    public function place()
    {
        return $this->belongsTo(BookingPlace::class, 'booking_place_id');
    }
}
