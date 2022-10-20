<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public static function getTitle($id)
    {
        $title = '';
        $designation = Designation::find($id);
        if(isset($designation->id))
        {
            $title = $designation->title;
        }
        return $title;
    }
}
