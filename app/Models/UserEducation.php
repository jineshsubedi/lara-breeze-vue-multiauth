<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    use HasFactory;

    protected $table = 'user_educations';
    
    protected $fillable = [
        'education_level_id',
        'faculty_id',
        'specialization',
        'institution',
        'year',
        'board',
        'marksystem',
        'user_id',
        'mark'
    ];

    public function education()
    {
        return $this->belongsTo(Education::class,'education_level_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class,'faculty_id');
    }
}
