<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantFormData extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'jobs_id', 'form_id', 'description', 'type', 'sn'];
}
