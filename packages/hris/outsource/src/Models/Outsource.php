<?php

namespace Hris\Outsource\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outsource extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'project_name', 'client_name', 'contract_start', 'contract_end', 'manager', 'supervisor', 'status');

    public function manager_person()
    {
        return $this->belongsTo(User::class, 'manager');
    }
    public function supervisor_person()
    {
        return $this->belongsTo(User::class, 'supervisor');
    }
    public function documents()
    {
        return $this->hasMany(OutSourceDocument::class, 'outsource_id');
    }
    public function purchase()
    {
        return $this->hasMany(OutSourcePurchaseOrder::class, 'outsource_id');
    }
    public function staffs()
    {
        return $this->hasMany(OutsourceStaffs::class, 'outsource_id');
    }
}
