<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'department_id', 'tor'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function tor(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::exists($value) ? Storage::url($value) : '',
        );
    }
}
