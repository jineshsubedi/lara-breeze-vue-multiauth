<?php

namespace Hris\Travel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentType extends Model
{
    use HasFactory;

    protected $fillable = array('title');
}
