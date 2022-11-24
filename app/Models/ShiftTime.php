<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftTime extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'title', 'start_time', 'end_time'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

}
