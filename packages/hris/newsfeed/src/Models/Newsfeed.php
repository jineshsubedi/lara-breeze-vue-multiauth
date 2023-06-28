<?php

namespace Hris\Newsfeed\Models;

use App\Library\Imagetool;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Newsfeed extends Model
{
    use HasFactory;

    protected $fillable = array('user_id', 'branch_id', 'to_staff', 'description', 'image', 'video', 'event', 'event_category');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function like()
    {
        return $this->hasMany(NewsfeedLike::class, 'newsfeed_id');
    }
    public function comment()
    {
        return $this->hasMany(NewsfeedComment::class, 'newsfeed_id');
    }
    public function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? Imagetool::mycrop($value, 500, 500) : ''
        );
    }
    public function video(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? $this->getEmbededUrl($value) : ''
        );
    }
    private function getEmbededUrl($value)
    {
        parse_str(parse_url($value, PHP_URL_QUERY), $params);
        $youtubeId = isset($params['v']) ? $params['v'] : null;
        return '//www.youtube.com/embed/'.$youtubeId;
    }
    public function event(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value)
        );
    }
}
