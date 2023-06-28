<?php

namespace Hris\Newsfeed\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsfeedLike extends Model
{
    use HasFactory;

    protected $fillable = array('user_id', 'newsfeed_id');

    public function newsfeed()
    {
        return $this->belongsTo(Newsfeed::class, 'newsfeed_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
