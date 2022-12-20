<?php

namespace Hris\Adjustment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustmentreason extends Model
{
    use HasFactory;

    protected $fillable = array('title');
}
