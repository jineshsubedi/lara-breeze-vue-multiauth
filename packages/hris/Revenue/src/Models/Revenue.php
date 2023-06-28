<?php

namespace Hris\Revenue\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable = array('division_id', 'branch_id', 'revenue', 'direct_expenses', 'indirect_expenses', 'net_profit', 'add_date');

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
