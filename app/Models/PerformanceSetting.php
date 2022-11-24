<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceSetting extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'title', 'duration', 'parameter');
}
