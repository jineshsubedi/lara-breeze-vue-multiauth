<?php

namespace Hris\Outsource\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutSourcePurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = array('outsource_id', 'number', 'department_id', 'from', 'to');

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
