<?php

namespace App\Traits;

use App\Library\Imagetool;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

trait UserRelation {

    public function getAvatarPathAttribute()
    {
        $path = 'no-image.png';
        if(!empty($this->avatar))
        {
            if (Storage::exists($this->avatar))
            {
                $path = $this->avatar;
            }
        }
        return Imagetool::mycrop($path, 300, 300);
    }

    // public function getUserPermissionAttribute() :array
    // {
    //     $permissions = Permission::all();
    //     $datas = [];
    //     foreach($permissions as $permission)
    //     {
    //         $datas[$permission->name] = \App\Models\User::find($this->id)->can($permission->name); 
    //     }
    //     return $datas;
    // }
}