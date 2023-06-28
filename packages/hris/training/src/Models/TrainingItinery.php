<?php

namespace Hris\Training\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingItinery extends Model
{
    use HasFactory;

    protected $fillable = array('training_id', 'idate', 'topic', 'start_time', 'end_time', 'duration');
}
