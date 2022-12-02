<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'user_id', 'leave_type_id', 'type', 'compensation', 'start_date', 's_approve', 'h_approve', 'm_approve', 'end_date', 'duration', 'description', 'contact_no', 'maximum_leave', 's_remarks', 'm_remarks', 'h_remarks', 'paid', 'emergency', 'document'];

    CONST LEAVE_NATURE_FULL = 1;
    CONST LEAVE_NATURE_HALF = 2;
    CONST LEAVE_NATURE_QUARTER = 3;

    CONST PAID_LEAVE = 1;
    CONST UNPAID_LEAVE = 0;

    public static function getLeaveNatures()
    {
        return [
            'Full Day' => self::LEAVE_NATURE_FULL,
            'Half Day' => self::LEAVE_NATURE_HALF,
            'Quarter Day' => self::LEAVE_NATURE_QUARTER
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }
}
