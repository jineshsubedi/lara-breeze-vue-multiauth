<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
use Carbon\Carbon;

trait UserRelation {

    public function getAvatarPathAttribute()
    {
        if(!empty($this->avatar))
        {
            if (Storage::exists($this->avatar))
            {
                return Imagetool::mycrop($this->avatar, 300, 300);
            }
        }
        return "https://ui-avatars.com/api/?name=".$this->name."&size=100";
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
        return $this->belongsTo(User::class,'supervisor_id')->select('id', 'name');
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
    public function scopeResign($query)
    {
        return $query->whereStatus(User::RESIGNED);
    }
    public function scopeBranchId($query)
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
    public function scopeSubordinate($query)
    {
        return $query->where('supervisor_id', auth()->id());
    }
    public function weekend(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => explode(',', $value),
            set: fn ($value) => implode(',', $value),
        );
    }
    public function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->userStatusLabel(),
        );
    }
    public function primaryLocation(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->address ? $this->address->primary_location : '27.6938264,85.3239504',
        );
    }
    private function userStatusLabel()
    {
        if($this->status == User::CURRENTLY_WORKING)
        {
            return '<span class="badge bg-success">Active</span>';
        }
        if($this->status == User::ABSCONDING)
        {
            return '<span class="badge bg-warning">Absconding</span>';
        }
        if($this->status == User::RESIGNED)
        {
            return '<span class="badge bg-primary">Resigned</span>';
        }
        if($this->status == User::TERMINATED)
        {
            return '<span class="badge bg-danger">Terminated</span>';
        }
    }
    public static function setWeekend()
    {
        $weekend = auth()->user()->weekend;
        if(is_array($weekend))
        {
            $wekSTr = [];
            if (in_array('SUNDAY', $weekend)) {
                $wekSTr[] = Carbon::SUNDAY;
            }
            if (in_array('MONDAY', $weekend)) {
                $wekSTr[] = Carbon::MONDAY;
            }
            if (in_array('TUESDAY', $weekend)) {
            $wekSTr[] = Carbon::TUESDAY;
            }
            if (in_array('WEDNESDAY', $weekend)) {
            $wekSTr[] = Carbon::WEDNESDAY;
            }
            if (in_array('THURSDAY', $weekend)) {
            $wekSTr[] = Carbon::THURSDAY;
            }
            if (in_array('FRIDAY', $weekend)) {
            $wekSTr[] = Carbon::FRIDAY;
            }
            if (in_array('SATURDAY', $weekend)) {
            $wekSTr[] = Carbon::SATURDAY;
            }
            Carbon::setWeekendDays($wekSTr);

        }else{
            if (auth()->user()->weekend == 'SUNDAY') {
                 Carbon::setWeekendDays([Carbon::SUNDAY]);
               }
            if (auth()->user()->weekend == 'MONDAY') {
                 Carbon::setWeekendDays([Carbon::MONDAY]);
               }
            if (auth()->user()->weekend == 'TUESDAY') {
                 Carbon::setWeekendDays([Carbon::TUESDAY]);
               }
            if (auth()->user()->weekend == 'WEDNESDAY') {
                 Carbon::setWeekendDays([Carbon::WEDNESDAY]);
               }
            if (auth()->user()->weekend == 'THURSDAY') {
                 Carbon::setWeekendDays([Carbon::THURSDAY]);
               }
            if (auth()->user()->weekend == 'FRIDAY') {
                 Carbon::setWeekendDays([Carbon::FRIDAY]);
               }
            if (auth()->user()->weekend == 'SATURDAY') {
                Carbon::setWeekendDays([Carbon::SATURDAY]);
              }
        }
    }

    public function getEmploymentNatureAttribute()
    {
        if($this->provision_end_date != NULL)
        {
            if($this->provision_end_date >= date('Y-m-d'))
            {
                return '<span class="badge bg-warning">Provision</span>';
            }
        }
        return '<span class="badge bg-success">Permanent</span>';
    }
}