<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'first_name','middle_name','last_name','email', 'citizenship','gender', 'dob', 'marital_status', 'image', 'resume', 'cover_letter', 'permanent_address', 'temporary_address', 'home_phone', 'mobile', 'vehicle', 'license_of', 'status', 'apply_date', 'validation_token', 'age', 'total_experience', 'tracking_code', 'district', 'municipality', 'ward', 'trash'];

    protected $appends = ['name'];

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name.' '.$this->middle_name.' '.$this->last_name
        );
    }
    public function education()
    {
        return $this->hasMany(ApplicantEducation::class, 'applicant_id');
    }
    public function address()
    {
        return $this->hasMany(ApplicantAddress::class, 'applicant_id');
    }
    public function training()
    {
        return $this->hasMany(ApplicantTraining::class, 'applicant_id');
    }
    public function language()
    {
        return $this->hasMany(ApplicantLanguage::class, 'applicant_id');
    }
    public function reference()
    {
        return $this->hasMany(ApplicantReference::class, 'applicant_id');
    }
    public function experience()
    {
        return $this->hasMany(ApplicantExperience::class, 'applicant_id');
    }

}
