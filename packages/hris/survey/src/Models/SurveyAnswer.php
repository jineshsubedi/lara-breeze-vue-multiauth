<?php

namespace Hris\Survey\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id', 'user_id', 'question', 'answer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
