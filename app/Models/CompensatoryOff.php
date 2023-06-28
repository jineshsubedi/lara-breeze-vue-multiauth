<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompensatoryOff extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'user_id','work_day','reason','inform_to','status','leave_status','remarks'];

    protected $appends = ['status_label', 'leave_status_label'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function informTo()
    {
        return $this->hasOne(User::class, 'id','inform_to');
    }
    public function leaveStatusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatus($this->leave_status), 
        );
    }
    public function getStatus($status)
    {
        $value = '';
        if($status == 1) {
            $value  .= '<span class="badge bg-success">Approved</span>';
        }
        elseif($status == 2){
            $value .= '<span class="badge  bg-danger">Canceled</span>';
        }
        else{
            $value .= ' <span class="badge  bg-info">Pending</span>';
        }
        return $value;
    }
    public function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getCompStatus($this->status), 
        );
    }
    public function getCompStatus($status)
    {
        if ($status == 1) {
            $data = '<span class="badge bg-success">Approved</span>';
        } elseif ($status == 0) {
            $data = '<span class="badge  bg-info">Pending</span>';
        } else{
            $data = '<span class="badge  bg-danger">Canceled</span>';
        }
        return $data;
    }
}
