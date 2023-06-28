<?php

namespace Hris\Outsource\Models;

use App\Library\Imagetool;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OutsourceStaffs extends Model
{
    use HasFactory;

    protected $fillable = array('outsource_id', 'staff_code', 'name', 'image', 'designation', 'department', 'temporary_address', 'phone_number', 'email', 'citizenship', 'sex', 'age', 'pan_number', 'ssf_number', 'join_date', 'contract_start', 'contract_end', 'status', 'education', 'dob', 'account_name', 'account_number', 'cit_number', 'emergency_name','emergency_relation', 'emergency_number', 'emergency_other_number','documents', 'asset_taken', 'medical');

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != '' && Storage::exists($value) ? Storage::url($value) : "https://ui-avatars.com/api/?name=".$this->name."&size=100",
        );
    }

    public function documents():Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != '' ? json_decode($value) : [],
            set: fn($value) => $value != '' ? json_encode($value) : []
        );
    }
    public function assetTaken():Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != '' ? json_decode($value) : [],
            set: fn($value) => $value != '' ? json_encode($value) : []
        );
    }
    public function medical():Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != '' ? json_decode($value) : [],
            set: fn($value) => $value != '' ? json_encode($value) : []
        );
    }

    public function contract()
    {
        return $this->hasMany(OutsourceStaffContract::class, 'outsource_staff_id');
    }
    public function current_contract()
    {
        return $this->hasOne(OutsourceStaffContract::class, 'outsource_staff_id')->where('current', 1);
    }
    public function checklist()
    {
        return $this->hasOne(OutsourceStaffChecklist::class, 'outsource_staff_id');
    }
    
}
