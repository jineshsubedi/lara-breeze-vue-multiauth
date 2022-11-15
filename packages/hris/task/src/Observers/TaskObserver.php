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
        $message = $task->fromUser->name.' has created a task for you. ['.$task->title.']';
        Notification::send($user, new TaskNotification($task, $message));
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
            $message = $task->toUser->name.' has accepted a task. ['.$task->title.']';
            Notification::send($user, new TaskNotification($task, $message));
        }
        if($task->isDirty('complete_date')){
            $user = User::find($task->task_from);
            $message = $task->toUser->name.' has completed a task. ['.$task->title.']';
            Notification::send($user, new TaskNotification($task, $message));
        }
        if($task->isDirty('complete_status')){
            $user = User::find($task->task_to);
            $message = $task->fromUser->name.' has closed a task. ['.$task->title.']';
            Notification::send($user, new TaskNotification($task, $message));
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
        $message = $task->fromUser->name.' has deleted a task assigned to you. ['.$task->title.']';
        Notification::send($user, new TaskNotification($task, $message));
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
}
