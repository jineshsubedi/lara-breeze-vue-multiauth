<?php

namespace Hris\Training\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TrainingNoticeNotification extends Notification
{
    use Queueable;

    protected $training;
    protected $message;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($training, $message, $link)
    {
        $this->training = $training;
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
            'id' => $this->training->id,
            'title' => $this->training->program?'[Training Notice] '.$this->training->program->title:'',
            'message' => Str::limit($this->message, 100),
            'url' => $this->link,
            'diff_time' => $this->training->updated_at,
            'module' => 'TRAINING NOTICE',
            'icon' => 'bi bi-easel text-success'
        ];
    }
}
