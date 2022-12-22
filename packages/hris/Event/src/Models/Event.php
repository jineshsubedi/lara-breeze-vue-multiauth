<?php

namespace Hris\Event\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['branch', 'title', 'description', 'document', 'banner', 'start_date', 'end_date'];

    protected $appends = ['document_url', 'banner_url'];

    protected function documentUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->document!='' && Storage::exists($this->document) ? Storage::url($this->document) : '',
        );
    }
    protected function bannerUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->banner!='' && Storage::exists($this->banner) ? Storage::url($this->banner) : '',
        );
    }
    public function branch(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }
}
