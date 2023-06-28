<?php

namespace Hris\Training\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TrainingAttachment extends Model
{
    use HasFactory;

    protected $fillable = array('training_id', 'attachment', 'extension', 'title');

    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value != '' && Storage::exists($value)) ? Storage::url($value) : '',
        );
    }
}
