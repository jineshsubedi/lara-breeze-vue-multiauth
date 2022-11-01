<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function scopeTitleList($query)
    {
        return $query->orderBy('id')->get(['id','title']);
    }
}
