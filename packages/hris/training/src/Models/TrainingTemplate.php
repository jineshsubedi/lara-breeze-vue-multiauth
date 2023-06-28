<?php

namespace Hris\Training\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingTemplate extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'training_id', 'title', 'description', 'schedule', 'share_with', 'schedule_date', 'schedule_end_date');

    protected $appends = ['shared'];

    public function shared(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getShareWithLabel($this->share_with)
        );
    }
    private function getShareWithLabel($share)
    {
        switch ($share) {
            case 1:
                return 'Trainer';
                break;
            case 2:
                return 'Trainee';
                break;
            default:
                return 'Both';
                break;
        }
    }

    public function answers()
    {
        return $this->hasMany(TrainingTemplateQuestionAnswer::class, 'training_template_id')->groupBy('staff_id', 'training_template_id');
    }
    public function qanswers()
    {
        return $this->hasMany(TrainingTemplateQuestionAnswer::class, 'training_template_id');
    }
}
