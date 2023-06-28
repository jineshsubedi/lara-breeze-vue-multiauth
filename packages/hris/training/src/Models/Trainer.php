<?php

namespace Hris\Training\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = array('name', 'email', 'designation', 'rate', 'charge_type', 'cv');

    protected function cv(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value != '' && Storage::exists($value)) ? Storage::url($value) : '',
        );
    }
}
