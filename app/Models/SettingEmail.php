<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_id', 'protocal', 'parameter', 'host_name', 'username', 'password', 'smtp_port', 'encryption'
    ];
}
