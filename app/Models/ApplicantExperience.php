<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantExperience extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'jobs_id', 'organization', 'type', 'designation', 'level', 'from', 'to', 'currently_working', 'country', 'duties', 'document', 'sn'];
}
