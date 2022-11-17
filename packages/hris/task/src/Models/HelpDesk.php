<?php

namespace Hris\Task\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserKra;
use App\Models\Branch;
use App\Models\User;

class HelpDesk extends Model
{
    use HasFactory;

    protected $fillable = array('task_to', 'task_from','title', 'description', 'accept_status', 'priority', 'complete_status', 'start_time', 'finish_time', 'remarks', 'kra_id', 'task_id', 'parent_id', 'job_id', 'branch_id');

    protected $appends = ['priority_label', 'complete_status_label'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

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

    protected function completeStatusLabel(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->CSTATUS($value),
        );
    }
    private function CSTATUS($value)
    {
        if($value == 0 && $this->accept_status == '0'){
            return '<span class="badge bg-secondary">Pending</span>';
        }
        if($value == 0 && $this->accept_status == '1' && $this->complete_status != '1'){
            return '<span class="badge bg-info text-dark">Progress</span>';
        }
        if($value == 0 && $this->accept_status == '1' && $this->finish_time < Date('Y-m-d') && $this->complete_status != '1'){
            return '<span class="badge bg-warning text-dark">Deadline Crossed</span>';
        }
        if($this->complete_status == '1'){
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
}
