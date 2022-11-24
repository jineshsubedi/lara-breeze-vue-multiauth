<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'leave_type_id', 'type', 'compensation', 'start_date', 's_approve', 'h_approve', 'm_approve', 'end_date', 'duration', 'description', 'contact_no', 'maximum_leave', 's_remarks', 'm_remarks', 'h_remarks', 'paid', 'emergency', 'document'];
}
