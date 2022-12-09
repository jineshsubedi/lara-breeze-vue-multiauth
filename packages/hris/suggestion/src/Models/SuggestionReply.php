<?php

namespace Hris\Suggestion\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestionReply extends Model
{
    use HasFactory;

    protected $fillable = array('suggestion_box_id', 'description', 'user_id');

    public function suggestionBox()
    {
    	return $this->belongsTo(SuggestionBox::class, 'suggestion_box_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
