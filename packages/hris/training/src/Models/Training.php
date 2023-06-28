<?php

namespace Hris\Training\Models;

use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = array('branch_id', 'training_program_id', 'level', 'from', 'to', 'status', 'trainer_id', 'budget', 'venue', 'total_participant');

    protected $appends = ['status_label', 'leveling'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function program()
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id');
    }
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
    public function notice()
    {
        return $this->hasOne(TrainingNotice::class, 'training_id');
    }
    public function category()
    {
        return $this->hasMany(TrainingItinery::class, 'training_id');
    }
    public function costs()
    {
        return $this->hasMany(TrainingCost::class, 'training_id');
    }
    public function participant()
    {
        return $this->hasMany(TrainingParticipant::class, 'training_id');
    }
    public function template()
    {
        return $this->hasMany(TrainingTemplate::class, 'training_id');
    }
    public function materials()
    {
        return $this->hasMany(TrainingAttachment::class, 'training_id');
    }
    public function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getStatusLabel($this->status)
        );
    }
    public function leveling(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getUserLevel($this->level)
        );
    }
    private function getStatusLabel($status)
    {
        $label = '';
        switch ($status) {
            case 0:
                $label = '<span class="badge bg-secondary">Draft</span>';
                break;
            case 1:
                $label = '<span class="badge bg-success">Active</span>';
                break;
            case 2:
                $label = '<span class="badge bg-warning">InActive</span>';
                break;
            default:
                $label = '';
                break;
        }
        return $label;
    }
    private function getUserLevel($label)
    {
        if($label == 1)
            return 'Begineer';
        if($label == 2)
            return 'Intermediate';
        if($label == 3)
            return 'Advanced';
        if($label == 4)
            return 'Master';
        return ' ';
    }

    public static function getYear()
    {
        $trainings = self::where('status', 1)->get(['created_at']);
        $years[] = Date('Y');
        foreach($trainings as $training)
        {
            $years[] = Carbon::parse($training->created_at)->format('Y');
        }
        return array_unique($years);
    }
}
