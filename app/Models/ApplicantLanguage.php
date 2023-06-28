<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantLanguage extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'jobs_id', 'language', 'understand', 'speak', 'reading', 'writing', 'mother_t', 'sn'];
}
