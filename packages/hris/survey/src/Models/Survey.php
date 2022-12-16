<?php

namespace Hris\Survey\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'title', 'description', 'start_date','end_date', 'status'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function question()
    {
        return $this->hasMany(SurveyQuestion::class, 'survey_id');
    }
    public function answer()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_id');
    }
}
