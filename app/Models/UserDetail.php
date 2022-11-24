<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenure',
        'marital_status',
        'work_mode',
        'citizenship_no',
        'resigned_date',
        'resigned_reason',
        'assets_taken',
        'blood_group',
        'nature_of_employment',
        'grade_position',
        'grade_no'
    ];
}
