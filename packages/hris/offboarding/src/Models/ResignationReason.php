<?php

namespace Hris\Offboarding\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResignationReason extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'title');

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function scopeBranchId($query)
    {
        return $query->where('branch_id', auth()->user()->branch_id);
    }
}
