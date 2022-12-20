<?php

namespace Hris\Adjustment\Models;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasFactory;

    protected $fillable = array('user_id', 'login_date', 'login_time', 'logout_time', 'adjustment_reason_id', 'time_to_be_adjusted', 'informed_to', 'remarks', 'status', 'branch_id');

    protected $appends = ['status_label'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function category()
    {
        return $this->belongsTo(Adjustmentreason::class, 'adjustment_reason_id');
    }
    public function inform()
    {
        return $this->belongsTo(User::class, 'informed_to');
    }

    public function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatus($this->status)
        );
    }
    public function getStatus($id)
     {
     	if ($id == 0) {
     		$title = '<small class="badge bg-primary">Waiting for Approval</small>';
     	} elseif ($id == 1) {
     		$title = '<small class="badge bg-success">Approved by Supervisor</small>';
     	} elseif ($id == 2) {
     		$title = '<small class="badge bg-success">Approved</small>';
     	} elseif ($id == 3){
     		$title = '<small class="badge bg-danger">Not Approved</small>';
     	} else{
            $title = '';
        }
     	return $title;
     }
}
