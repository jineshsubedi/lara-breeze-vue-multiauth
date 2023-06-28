<?php

namespace App\Models;

use App\Enums\AppConstant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Jobs extends Model
{
    use HasFactory;

    protected $fillable = array('title', 'branch_id', 'location_title', 'job_level', 'job_availability', 'deadline', 'min_experience', 'education_level', 'faculty', 'position', 'vacancy_code', 'external_link', 'gender', 'salary_unit', 'negotiable', 'minimum_salary', 'min_age', 'max_age', 'status', 'seo_url', 'setting', 'apply_type', 'emails', 'formfields', 'education_levels', 'emanual', 'applicantPstatus', 'publish_date', 'assignment_handeler', 'job_file', 'advertise_detail', 'advertise_link', 'image', 'line_manager','edu_marks','exp_marks', 'sort_order');

    protected $appends = ['status_label'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function process()
    {
        return $this->belongsTo(RecruitmentProcess::class, 'process_status');
    }
    public function requirement()
    {
        return $this->hasOne(JobRequirements::class, 'jobs_id');
    }
    public function educations()
    {
        return $this->hasMany(JobEducation::class, 'jobs_id');
    }
    public function locations()
    {
        return $this->hasMany(JobsLocation::class, 'jobs_id');
    }
    public function jobforms()
    {
        return $this->hasMany(JobForm::class, 'jobs_id');
    }
    public function applicantProcess()
    {
        return $this->hasMany(ApplicationProcess::class, 'jobs_id');
    }
    public function applications()
    {
        return $this->hasMany(Applicant::class, 'jobs_id');
    }
    public function advertiseImage(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->image != null ? Storage::url($this->image) : ''
        );
    }
    public function jobFile():Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? Storage::url($value) : '' 
        );
    }

    public function formfields(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? json_decode($value) : [],
            set: fn($value) => $value != null ? json_encode($value) : null
        );
    }
    public function educationLevels(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? json_decode($value) : [],
            set: fn($value) => $value != null ? json_encode($value) : null
        );
    }
    public function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getConstantLabel($this->status, AppConstant::JOB_STATUS) 
        );
    }
    public function setting(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getConstantLabel($value, AppConstant::JOB_SETTING) 
        );
    }
    public static function getConstantLabel($value, $answers)
    {
        $key = array_search($value, array_column($answers, 'value'));
        return $answers[$key]['title'];
    }
    
}
