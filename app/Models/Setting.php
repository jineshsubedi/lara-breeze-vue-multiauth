<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Library\Imagetool;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'icon', 'description_limit', 'item_perpage', 'google_analytics', 'latitude', 'longitude', 'status', 'meta_title', 'meta_keyword', 'meta_description', 'email', 'address', 'phone'
    ];

    public function emails()
    {
        return $this->hasOne(SettingEmail::class, 'setting_id');
    }
    public function socials()
    {
        return $this->hasMany(SettingSocial::class, 'setting_id');
    }
    public function getIconPathAttribute()
    {
        $path = 'no-image.png';
        if(!empty($this->icon))
        {
            if (Storage::exists($this->icon))
            {
                $path = $this->icon;
            }
        }
        return Imagetool::mycrop($path, 100, 100);
    }
    public function getLogoPathAttribute()
    {
        $path = 'no-image.png';
        if(!empty($this->logo))
        {
            if (Storage::exists($this->logo))
            {
                $path = $this->logo;
            }
        }
        return Imagetool::mycrop($path, 100, 100);
    }
}
