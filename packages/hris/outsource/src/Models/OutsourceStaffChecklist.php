<?php

namespace Hris\Outsource\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutsourceStaffChecklist extends Model
{
    use HasFactory;

    protected $fillable = array('outsource_staff_id', 'group_medical_insurance', 'group_accidental_insurance', 'assets', 'id_card', 'experience_letter', 'salary_settlement', 'warning_letter', 'pending_work', 'advance_payment');
}
