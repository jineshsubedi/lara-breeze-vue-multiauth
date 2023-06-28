<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'institution',
        'duration',
        'start_date',
        'end_date',
        'user_id'
    ];
}
