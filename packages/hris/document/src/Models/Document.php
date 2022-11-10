<?php

namespace Hris\Document\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'department_id', 'title', 'description', 'document'];

    protected function branchId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }

    protected function departmentId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }

    protected function document(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::exists($value) ? Storage::url($value) : '',
        );
    }
}
