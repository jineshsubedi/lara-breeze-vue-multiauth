<?php

namespace Hris\Booking\Models;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'place_id', 'hall_id', 'purpose_id', 'booked_by', 'booking_date', 'start_time', 'description', 'end_time');

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function place()
    {
        return $this->belongsTo(BookingPlace::class, 'place_id');
    }
    public function hall()
    {
        return $this->belongsTo(BookingHall::class, 'hall_id');
    }
    public function purpose()
    {
        return $this->belongsTo(BookingPurpose::class, 'purpose_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }
    public function staffs()
    {
        return $this->hasMany(BookingStaffs::class, 'booking_id');
    }
}
