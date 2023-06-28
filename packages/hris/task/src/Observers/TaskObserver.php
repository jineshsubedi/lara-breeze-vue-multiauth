<?php

namespace Hris\Task\Observers;

use App\Models\User;
use Hris\Task\Models\Task;
use Hris\Task\Notifications\TaskNotification;
use Illuminate\Support\Facades\Notification;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->load(['fromUser:id,name', 'toUser:id,name']);
        $user = User::find($task->task_to);
        $message = $task->fromUser->name.' Has Assigned a Task for you.';
        $link = $this->staffUrl($user, $task->id);
        Notification::send($user, new TaskNotification($task, $message, $link));
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        $task->load(['fromUser:id,name', 'toUser:id,name']);
        if($task->isDirty('accept_date')){
            $user = User::find($task->task_from);
            $message = $task->toUser->name.' Has Accepted a Task';
            $link = $this->staffUrl($user, $task->id);
            Notification::send($user, new TaskNotification($task, $message, $link));
        }
        if($task->isDirty('complete_date')){
            $user = User::find($task->task_from);
            $message = $task->toUser->name.' Has Partially Completed a Task';
            $link = $this->staffUrl($user, $task->id);
            Notification::send($user, new TaskNotification($task, $message, $link));
        }
        if($task->isDirty('complete_status')){
            $user = User::find($task->task_to);
            $message = $task->fromUser->name.' Has Closed a Task';
            $link = $this->staffUrl($user, $task->id);
            Notification::send($user, new TaskNotification($task, $message, $link));
        }
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $task->load(['fromUser:id,name', 'toUser:id,name']);
        $user = User::find($task->task_to);
        $message = $task->fromUser->name.' Has Deleted a Task Assigned to You';
        $link = $this->staffUrl($user, $task->id);
        Notification::send($user, new TaskNotification($task, $message, $link));
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
    private function staffUrl($user, $id)
    {
        if($user->staff_type == 1)
        {
            return route('admin.tasks.show', $id);
        }
        if($user->staff_type == 2)
        {
            return route('supervisor.tasks.show', $id);
        }
        if($user->staff_type == 3)
        {
            return route('staffs.tasks.show', $id);
        }
    }
}
