<?php

namespace Hris\Training\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TrainingNotice extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'training_program_id', 'training_id', 'notice_date', 'submit_date', 'description', 'document');

    protected function document(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != '' && Storage::exists($value) ? Storage::url($value) : '',
        );
    }
}
