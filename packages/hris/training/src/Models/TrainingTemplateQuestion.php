<?php

namespace Hris\Training\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TrainingTemplateQuestion extends Model
{
    use HasFactory;

    protected $fillable = array('training_template_id', 'question', 'type', 'list_menu', 'mandatory', 'order');

    protected $appends = ['lmenus'];

    public function lmenus(): Attribute
    {
        return Attribute::make(
            get: fn () => explode(',', $this->list_menu),
        );
    }
}
