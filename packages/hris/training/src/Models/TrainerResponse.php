<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerResponse extends Model
{
    use HasFactory;

    protected $fillable = array('token', 'training_id', 'email', 'training_template_id', 'invoke');
}
