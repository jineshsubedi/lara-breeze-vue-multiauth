<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsLocation extends Model
{
    use HasFactory;

    protected $fillable = array('jobs_id', 'job_location_id');

}
