<?php

namespace Hris\Survey\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'parent_id', 'label', 'type', 'list_menu', 'required', 'extra', 'sort'];
    
    protected $appends = ['lmenus', 'parent_label'];

    public function lmenus(): Attribute
    {
        return Attribute::make(
            get: fn () => explode(',', $this->list_menu),
        );
    }
    public function parentLabel(): Attribute
    {
        $question = SurveyQuestion::find($this->parent_id);
        return Attribute::make(
            get: fn () => isset($question->id) ? $question->label : '',
        );
    }
}

