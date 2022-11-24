<?php

namespace Hris\Task\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserKra;
use App\Models\User;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['parent_type','parent_id','task_from','task_to','title','description','complete_status','accept_date','complete_date','start_time','finish_time','remarks','s_remarks','priority','self_mark','supervisor_mark','num_task','kra_id','project','personal','weightage'];

    protected $appends = ['priority_label', 'diff_time'];

    public function fromUser()
    {
        return $this->belongsTo(User::class,'task_from');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class,'task_to');
    }

    public function kra()
    {
        return $this->belongsTo(UserKra::class, 'kra_id');
    }
    public function jobs()
    {
        return $this->hasMany(TaskJob::class, 'task_id');
    }
    protected function completeStatus(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => [$value, $this->CSTATUS($value)],
        );
    }
    private function CSTATUS($value)
    {
        if($value == 0 && $this->accept_date == null){
            return '<span class="badge bg-secondary">Pending</span>';
        }
        if($value == 0 && $this->accept_date != null){
            return '<span class="badge bg-info text-dark">Progress</span>';
        }
        if($value == 0 && $this->accept_date != null && $this->finish_time < Date('Y-m-d') && $this->complete_date == null){
            return '<span class="badge bg-warning text-dark">Deadline Crossed</span>';
        }
        if($value == 0 && $this->accept_date != null && $this->finish_time < Date('Y-m-d') && $this->complete_date != null){
            return '<span class="badge bg-warning text-dark">Deadline Crossed & Partial Complete</span>';
        }
        if($value == 0 && $this->accept_date != null && $this->finish_time > $this->complete_date && $this->complete_date != null){
            return '<span class="badge bg-primary">Partial Complete</span>';
        }
        if($value == 1){
            return '<span class="badge bg-success">Completed</span>';
        }
    }
    protected function priorityLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getPriorityLabel($this->priority),
        );
    }
    private function getPriorityLabel($value)
    {
        switch ($value) {
            case 1:
                return 'Low Priority';
                break;
            case 2:
                return 'Medium Priority';
                break;
            case 3:
                return 'High Priority';
                break;
            case 4:
                return 'Highest Priority';
                break;
            case 5:
                return 'Non Priority';
                break;
            default:
                return '';
                break;
        }
    }

    protected function diffTime(): Attribute 
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->updated_at)->diffForHumans(),
        );
    }
}
