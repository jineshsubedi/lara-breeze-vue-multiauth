<?php

namespace Hris\Outsource\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutsourceStaffContract extends Model
{
    use HasFactory;

    protected $fillable = array('outsource_staff_id', 'position', 'salary', 'contract_start', 'contract_end', 'current');
}
