<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobEducation extends Model
{
    use HasFactory;

    protected $fillable = array('jobs_id', 'education_level_id', 'faculty_id', 'experience', 'exp_format', 'percent', 'cgpa', 'others');
}
