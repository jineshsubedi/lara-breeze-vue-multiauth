<?php

namespace Hris\Offboarding\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminationType extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'title');

    public function scopeBranchId($query)
    {
        return $query->where('branch_id', auth()->user()->branch_id);
    }
}
