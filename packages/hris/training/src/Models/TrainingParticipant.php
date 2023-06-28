<?php

namespace Hris\Training\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingParticipant extends Model
{
    use HasFactory;

    protected $fillable = array('training_id', 'user_id', 'status', 'description');

    protected $appends = ['status_label'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function statusLabel():Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLebel($this->status)
        );
    }
    private function getStatusLebel($status)
    {
        if($status == 1)
            return '<span class="badge bg-success">Active</span>';
        if($status == 2)
            return '<span class="badge bg-danger">Rejected</span>';
        return '<span class="badge bg-secondary">Pending</span>';
    }
}
