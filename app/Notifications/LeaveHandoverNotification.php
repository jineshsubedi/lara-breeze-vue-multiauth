<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class LeaveHandoverNotification extends Notification
{
    use Queueable;

    protected $leave;
    protected $message;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leave, $message, $link)
    {
        $this->leave = $leave;
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
            'id' => $this->leave->id,
            'title' => 'Handover Request',
            'message' => Str::limit($this->message, 100),
            'url' => $this->link,
            'diff_time' => $this->leave->created_at,
            'module' => 'HANDOVER REQUEST',
            'icon' => 'bi bi-pc-display text-info'
        ];
    }
}
