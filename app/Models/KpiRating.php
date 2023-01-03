<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiRating extends Model
{
    use HasFactory;

    protected $fillable = array('user_kpi_id', 'rate_by', 'rating', 'detail');

    public function Kpi()
    {
    	return $this->belongsTo(UserKpi::class, 'user_kpi_id');
    }
    public function rater()
    {
    	return $this->belongsTo(User::class, 'rate_by');
    }
    public static function getRating($kpi,$quarter)
    {
        
        $rating = KpiRating::where('user_kpi_id', $kpi)->where('created_at', 'LIKE', $quarter.'%')->first();
        $data = '0.00';
        if(isset($rating->rating))
        {
            $data = $rating->rating;
        }
        return $data;
    }
}
