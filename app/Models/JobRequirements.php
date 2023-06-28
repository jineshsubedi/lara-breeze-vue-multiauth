<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequirements extends Model
{
    use HasFactory;

    protected $fillable = array('jobs_id', 'description', 'specification', 'education_description', 'specific_requirement', 'specific_instruction');
}
