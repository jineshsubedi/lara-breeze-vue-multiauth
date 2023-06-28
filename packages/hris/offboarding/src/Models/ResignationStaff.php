<?php

namespace Hris\Offboarding\Models;

use App\Models\Branch;
use App\Models\User;
use Hris\Offboarding\Enums\ResignationStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResignationStaff extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'user_id', 'resignation_reason_id', 'resignation_type_id', 'resignation_detail', 'resignation_date', 'status', 'supervisor', 'supervisor_approval_date', 'supervisor_approval_detail', 'supervisor_approval_status', 'approval_by', 'approval_detail', 'approval_date', 'offBoarding_date', 'settlement_letter', 'retract');

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function authorize_user(){
        return $this->belongsTo(User::class,'approval_by');
    }
    public function supervisor_user(){
        return $this->belongsTo(User::class,'supervisor');
    }
    public function type(){
        return $this->belongsTo(ResignationType::class,'resignation_type_id');
    }
    public function reason(){
        return $this->belongsTo(ResignationReason::class,'resignation_reason_id');
    }
    public function retraction()
    {
        return $this->hasOne(ResignationRetraction::class, 'resignation_staffs_id');
    }
    public function retract():Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getRetractStatus($value) 
        );
    }
    public function getRetractStatus($value)
    {
        if($value == 0)
            return '';
        if($value == 1)
            return '<span class="badge bg-success">Accepted</span>';
        if($value == 2)
            return '<span class="badge bg-danger">Rejected</span>';
    }
}
