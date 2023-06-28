<?php

namespace Hris\Suggestion\Models;

use App\Models\Branch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestionBox extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'user_id', 'suggestion_for_id', 'hide_name', 'description');

    protected $appends = ['request_date'];

    public function branch()
    {
    	return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
    public function SuggestionFor()
    {
    	return $this->belongsTo(SuggestionFor::class, 'suggestion_for_id');
    }
    public function suggestion_reply()
    {
    	return $this->hasMany(SuggestionReply::class, 'suggestion_box_id');
    }
    public function scopeBranchId($query)
    {
        return $query->where('branch_id', auth()->user()->branch_id);
    }
    public function requestDate():Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->created_at)->format('d M, Y h:i a'),
        );
    }
}
