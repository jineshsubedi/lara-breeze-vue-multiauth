<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserDocument extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','title','document'];

    public function getDocumentPathAttribute()
    {
        $findme   = 'http';
        $pos = strpos($this->document, $findme);

        if ($pos !== false)
        {
            return $this->document;
        }
        if (Storage::exists($this->document))
        {
            return Storage::url($this->document);
        }

        return '';
    }
}
