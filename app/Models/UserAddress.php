<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pdistrict_id',
        'tdistrict_id',
        'p_address',
        't_address',
        'emergency_number',
        'primary_location',
        'contact_person',
        'contact_person_number',
        'home_location',
        'phone_number',
    ];

    public function pdistrict()
    {
        return $this->belongsTo(District::class, 'pdistrict_id');
    }
    public function tdistrict()
    {
        return $this->belongsTo(District::class, 'tdistrict_id');
    }
}
