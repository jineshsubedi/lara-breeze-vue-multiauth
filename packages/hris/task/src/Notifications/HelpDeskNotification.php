<?php

namespace Hris\Task\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;

class HelpDeskNotification extends Notification
{
    use Queueable;

    protected $task;
    protected $message;
    protected $link;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task, $message, $link)
    {
        $this->task = $task;
        $this->link = $link;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->task->id,
            'title' => $this->task->title,
            'message' => Str::limit($this->message, 100),
            'url' => $this->link,
            'diff_time' => $this->task->updated_at,
            'module' => 'TASK',
            'icon' => 'bi bi-pc-horizontal text-info'
        ];
    }
}
