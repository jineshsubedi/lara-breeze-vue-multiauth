<?php

namespace Hris\Task\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class TaskJob extends Model
{
    use HasFactory;

    protected $fillable = array('task_id', 'title','complete_status', 'start_date', 'end_date', 'description', 'priority','image');

    protected function priority(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->priorityLabel($value),
        );
    }
    private function priorityLabel($value)
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
    protected function completeStatus(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => [$value, $this->CSTATUS($value)],
        );
    }
    private function CSTATUS($value)
    {
        if($value == 0){
            return '<span class="badge bg-secondary">Pending</span>';
        }
        if($value == 1){
            return '<span class="badge bg-success">Completed</span>';
        }
    }
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::exists($value) && $value != '' ? Storage::url($value) : '',
        );
    }
}
