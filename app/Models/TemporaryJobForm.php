<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryJobForm extends Model
{
    use HasFactory;

    protected $fillable = array('session_id', 'f_lable', 'f_type', 'list_menu', 'required', 'parent_id', 'marks', 'extra');

    protected $appends = ['parent', 'require'];

    public function parent(): Attribute
    {   
        return Attribute::make(
            get: fn() => $this->parent_id != null ? $this->getTitle($this->parent_id) : ''
        );
    }
    private function getTitle($value)
    {
        $form = self::find($value);
        if($form)
            return $form->f_lable;
        else
            return '';
    }

    public function require(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->required == 1 ? 'Required' : 'Optional'
        );
    }
}
