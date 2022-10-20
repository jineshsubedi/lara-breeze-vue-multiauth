<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['province_id','title'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public static function getDistrict($p,$d)
    {
        $districts = District::where('province_id', $p)->orderBy('title', 'asc')->get();
        $data = '<option value="">Select District</option>';
        foreach ($districts as $istrict) {
            if ($istrict->id == $d) {
                $data .= '<option selected="selected" value="'.$istrict->id.'">'.$istrict->title.'</option>';
            } else {
                $data .= '<option value="'.$istrict->id.'">'.$istrict->title.'</option>';
            }

        }
        return $data;
    }
}
