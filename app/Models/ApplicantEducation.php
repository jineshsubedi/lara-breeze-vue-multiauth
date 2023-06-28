<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEducation extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'jobs_id', 'country', 'educationlevel_id', 'faculty_id', 'status', 'specialization', 'institution', 'board', 'percentage', 'marksystem', 'year', 'document', 'sn'];
}
