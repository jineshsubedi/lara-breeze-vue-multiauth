<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\UserRelation;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, UserRelation, HasRoles;

    const CURRENTLY_WORKING = 1;
    const RESIGNED = 2;
    const ABSCONDING = 3;
    const TERMINATED = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'father_name',
        'employee_code',
        'email',
        'password',
        'staff_type',
        'branch_id',
        'department_id',
        'designation_id',
        'shift_time_id',
        'supervisor_id',
        'status',
        'gender',
        'employment_type',
        'salary_type',
        'dob',
        'join_date',
        'provision_end_date',
        'avatar',
        'weekend',
        'primary_location',
        'app_token',
        'imei'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['status_label', 'primary_location', 'avatar_path'];
}
