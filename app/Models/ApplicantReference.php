<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantReference extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'jobs_id', 'name', 'designation', 'address', 'office_phone', 'mobile', 'email', 'company', 'sn'];
}
