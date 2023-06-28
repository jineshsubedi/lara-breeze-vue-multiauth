<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationProcess extends Model
{
    use HasFactory;

    protected $fillable = ['jobs_id', 'title','email_text','candidate','sort_order'];

    public function candidate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? json_decode($value) : [],
            set: fn($value) => $value != null ? json_encode($value) : [],
        );
    }
}
