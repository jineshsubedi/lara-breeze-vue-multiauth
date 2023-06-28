<?php

namespace Hris\Travel\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelReply extends Model
{
    use HasFactory;

    protected $fillable = array('travel_id', 'description', 'user_id');

    public function travel()
    {
    	return $this->belongsTo(Travel::class, 'travel_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
