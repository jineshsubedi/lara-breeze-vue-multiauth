<?php

namespace Hris\Training\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    use HasFactory;

    protected $fillable = array('title');

    public function training()
    {
        return $this->hasMany(Training::class, 'training_program_id');
    }
}
