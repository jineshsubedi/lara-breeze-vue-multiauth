<?php

namespace Hris\Offboarding\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffboardSetting extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'retirement', 'retirement_alert', 'retraction');

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
