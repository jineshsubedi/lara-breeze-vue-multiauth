<?php

namespace Hris\Interview\Models;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitInterview extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'user_id', 'interview_date', 'service_tenure', 'received_by', 'description');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function received()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function description():Attribute 
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }
}
