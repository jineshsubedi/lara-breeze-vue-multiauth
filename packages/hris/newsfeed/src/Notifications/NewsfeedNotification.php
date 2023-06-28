<?php

namespace Hris\Newsfeed\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewsfeedNotification extends Notification
{
    use Queueable;

    protected $newsfeed;
    protected $message;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($newsfeed, $message, $link)
    {
        $this->newsfeed = $newsfeed;
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
            'id' => $this->newsfeed->id,
            'title' => 'Newsfeed',
            'message' => Str::limit($this->message, 100),
            'url' => $this->link,
            'diff_time' => $this->newsfeed->updated_at,
            'module' => 'NEWSFEED',
            'icon' => 'bi bi-rss-fill text-primary'
        ];
    }
}
