<?php

namespace Hris\Onboarding\Models;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Hris\Hrletter\Models\LetterType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OnBoardStaff extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'supervisor_id','name', 'email', 'staff_type', 'nature_of_job', 'nature_of_employment', 'department_id', 'designation_id', 'level', 'salary', 'trail_period', 'no_of_days', 'trail_start_date', 'joining_date', 'offer_letter', 'letter_accept_date', 'cv', 'supervisor_approval', 'supervisor_comment', 'supervisor_approval_date', 'hr_approval', 'hr_comment', 'hr_approval_date');

    protected $appends = ['staff_type_label'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function supervisor()
    {
        return $this->belongsTo(User::class,'supervisor_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id');
    }
    public function letter()
    {
        try {
            return $this->belongsTo(LetterType::class,'offer_letter');
        } catch (\Throwable $th) {
            return '';
        }
    }
    protected function cv(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != '' && Storage::exists($value) ? Storage::url($value) : '',
        );
    }

    public function staffTypeLabel():Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStaffType($this->staff_type),
        );
    }
    protected function getStaffType($value)
    {
        $answers = config('onboardConstant.staff_types');
        $key = array_search($value, array_column($answers, 'value'));
        return $answers[$key]['title'];
    }
}
