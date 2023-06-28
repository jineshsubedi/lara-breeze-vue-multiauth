<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingSocial extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_id', 'name', 'icon', 'url'
    ];
}
