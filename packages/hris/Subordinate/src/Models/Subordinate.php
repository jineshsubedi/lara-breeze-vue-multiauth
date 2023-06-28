<?php

namespace Hris\Subordinate\Models;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subordinate extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'user_id', 'supervisor', 'comment','rating');

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function scopeBranchId($query)
    {
        return $query->where('branch_id', auth()->user()->branch_id);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor');
    }
}
