<?php

namespace Hris\Outsource\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OutSourceDocument extends Model
{
    use HasFactory;

    protected $fillable = array('outsource_id', 'type', 'title', 'file_name');

    Protected $appends = ['type_title', 'attachment'];

    public function typeTitle():Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getTypeTitle($value)
        );
    }
    public static function getTypeTitle($value)
    {
        $answers = config('outsourceConstant.types');
        $key = array_search($value, array_column($answers, 'value'));
        return $answers[$key]['title'];
    }

    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->file_name != '' && Storage::exists($this->file_name)) ? Storage::url($this->file_name) : '',
        );
    }
}
