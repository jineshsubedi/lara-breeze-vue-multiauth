<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveHandover extends Model
{
    use HasFactory;

    protected $fillable = ['leave_id', 'user_id', 'status'];

    protected $appends = ['status_label'];

    public function leave()
    {
        return $this->belongsTo(Leave::class, 'leave_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatus($this->status)
        );
    	
    }
    private function getStatus($status)
    {
        if ($status == '1') {
            $status = '<span class="badge bg-success">Accepted</span>';
        } else{
            $status = '<span class="badge bg-secondary">Waiting</span>';
        }
        return $status;
    }
}
