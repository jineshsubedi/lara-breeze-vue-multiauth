<?php

namespace Hris\Suggestion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestionFor extends Model
{
    use HasFactory;

    protected $fillable = array('title');

}
