<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchSetting extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'revenue', 'canteen', 'client', 'performance', 'performance_rater', 'performance_rating_type', 'attendance_handler', 'account_handler', 'staff_handler', 'survey_handler', 'training_handler', 'account_handler_signature', 'hr_handler', 'out_source_handler', 'performance_rating', 'rating_time', 'salary_calculate', 'client_comment', 'comment_type');

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function outSourceHandler(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }
}
