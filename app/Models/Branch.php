<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email','description','province_id','district_id', 'is_head','login_ip'];
    
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function setting()
    {
        return $this->hasOne(BranchSetting::class);
    }
    public function performance()
    {
        return $this->hasMany(PerformanceSetting::class);
    }
    public function users()
    {
        return $this->hasMany(User::class, 'branch_id');
    }
    public function scopeBranchList($query)
    {
        if(!auth()->user()->roles->where('name', 'SuperAdmin')->first())
        {
            $query->where('id', auth()->user()->branch_id);
        }
        return $query->orderBy('id')->get(['id', 'name']);
    }
}
