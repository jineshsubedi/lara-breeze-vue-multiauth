<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['province_id','title'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function scopeTitleList($query)
    {
        return $query->orderBy('id')->get(['id','title']);
    }
}
