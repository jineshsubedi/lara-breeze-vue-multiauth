<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use App\Models\UserAllowance;
use App\Models\UserEducation;
use App\Models\UserDocument;
use App\Models\UserTraining;
use App\Models\Designation;
use App\Models\UserAddress;
use App\Library\Imagetool;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\UserDetail;
use App\Models\UserSalary;
use App\Models\ShiftTime;
use App\Models\District;
use App\Models\UserBank;
use App\Models\UserKpi;
use App\Models\UserKra;
use App\Models\Branch;
use App\Models\Leave;
use App\Models\User;

trait UserRelation {

    public function getAvatarPathAttribute()
    {
        $path = 'no-image.png';
        if(!empty($this->avatar))
        {
            if (Storage::exists($this->avatar))
            {
                $path = $this->avatar;
            }
        }
        return Imagetool::mycrop($path, 300, 300);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }
    public function address()
    {
        return $this->hasOne(UserAddress::class);
    }
    public function salary()
    {
        return $this->hasOne(UserSalary::class);
    }
    public function latestsalary()
    {
        return $this->hasOne(UserSalary::class)->orderBy('id','desc');
    }
    public function allowances()
    {
        return $this->hasManyThrough(UserAllowance::class,UserSalary::class);
    }

    public function bank()
    {
        return $this->hasOne(UserBank::class);
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }
    public function documents()
    {
        return $this->hasMany(UserDocument::class,'user_id');
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class,'user_id');
    }
    public function leducation()
    {
        return $this->hasOne(UserEducation::class,'user_id')->orderBy('year','desc');
    }

    public function trainings()
    {
        return $this->hasMany(UserTraining::class,'user_id');
    }
    public function todayattendance()
    {
        return $this->hasOne(Attendance::class)->where('attendance_date',date('Y-m-d'));
    }

    public function todayleave()
    {
        $today = date('Y-m-d');
        return $this->hasOne(Leave::class)->where('start_date', '<=', $today)->where('end_date', '>=', $today);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function pdistrict()
    {
        return $this->hasOneThrough(District::class,UserAddress::class,'user_id','id','id','pdistrict_id');
    }
    public function tdistrict()
    {
        return $this->hasOneThrough(District::class,UserAddress::class,'user_id','id','id','tdistrict_id');
    }
    public function shiftTime()
    {
        return $this->belongsTo(ShiftTime::class);
    }
    public function supervisor()
    {
        return $this->belongsTo(User::class,'supervisor_id');
    }

    public function kra()
    {
        return $this->hasMany(UserKra::class);
    }

    public function kpi()
    {
        return $this->hasMany(UserKpi::class);
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(User::CURRENTLY_WORKING);
    }
    public function scopeBranch($query)
    {
        return $query->whereBranchId(auth()->user()->branch_id);
    }
    public function scopeUserList($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('branch_id', auth()->user()->branch_id);
        }
        return $query;
    }
}