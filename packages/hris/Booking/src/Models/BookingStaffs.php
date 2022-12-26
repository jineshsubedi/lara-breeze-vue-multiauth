<?php

namespace Hris\Booking\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStaffs extends Model
{
    use HasFactory;

    protected $fillable = array('booking_id', 'staff_id', 'status','remarks');

    protected $appends = ['status_label'];

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function statusLabel():Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatus($this->status)
        );
    }
    protected function getStatus($value)
    {
        $result = '';
        switch ($value) {
            case '0':
                $result = '<span class="badge bg-secondary">Pending</span>';
                break;
            case '1':
                $result = '<span class="badge bg-success">Accepted</span>';
                break;
            case '2':
                $result = '<span class="badge bg-danger">Rejected</span>';
                break;
            default:
                break;
        }
        return $result;
    }
}
