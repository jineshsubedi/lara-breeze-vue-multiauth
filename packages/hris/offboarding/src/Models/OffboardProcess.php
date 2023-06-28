<?php

namespace Hris\Offboarding\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffboardProcess extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'department_id', 'title');

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
