<?php

namespace Hris\Overtime\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtimereason extends Model
{
    use HasFactory;

    protected $fillable = array('title');
}
