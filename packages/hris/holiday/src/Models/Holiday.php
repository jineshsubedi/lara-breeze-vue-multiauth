<?php

namespace Hris\Holiday\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'branch_id', 'start_date', 'end_date'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

}
