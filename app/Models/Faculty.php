<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = array('education_id', 'title');

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }
}
