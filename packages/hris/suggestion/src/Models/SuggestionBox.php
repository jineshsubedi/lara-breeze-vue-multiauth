<?php

namespace Hris\Suggestion\Models;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestionBox extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'user_id', 'suggestion_for_id', 'hide_name', 'description');

    public function branch()
    {
    	return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
    public function SuggestionBox()
    {
    	return $this->belongsTo(SuggestionFor::class, 'suggestion_for_id');
    }
}
