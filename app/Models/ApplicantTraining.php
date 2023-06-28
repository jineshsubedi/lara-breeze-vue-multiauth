<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantTraining extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'jobs_id', 'title', 'details', 'institution', 'duration', 'document', 'sn'];
}
