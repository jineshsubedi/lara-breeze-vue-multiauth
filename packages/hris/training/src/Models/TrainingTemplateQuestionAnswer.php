<?php

namespace Hris\Training\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingTemplateQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = array('question_id', 'answer', 'score', 'staff_id', 'training_template_id', 'type', 'answer_date', 'training_id', 'is_trainer');

    protected $appends = ['score_board'];

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }
    public function template()
    {
        return $this->belongsTo(TrainingTemplate::class, 'training_template_id');
    }
    public function scoreBoard():Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMyTotalAnswer($this->training_template_id, $this->staff_id)
        );
    }
    public function getMyTotalAnswer($tempId, $userId)
    {
        $total = self::where('training_template_id', $tempId)->where('staff_id', $userId)->where('type', 'multiple')->count() * 5;
        $score = self::where('training_template_id', $tempId)->where('staff_id', $userId)->where('type', 'multiple')->sum('score');
        return [
            'total' => $total,
            'score' => $score
        ];
    }
}
