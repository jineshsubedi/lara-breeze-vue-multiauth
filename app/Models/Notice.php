<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'title', 'description', 'start_date', 'end_date');

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
