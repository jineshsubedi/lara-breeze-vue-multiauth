<?php

namespace Hris\Training\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCost extends Model
{
    use HasFactory;

    protected $fillable = array('training_id', 'title', 'total_cost', 'quantity');
}
