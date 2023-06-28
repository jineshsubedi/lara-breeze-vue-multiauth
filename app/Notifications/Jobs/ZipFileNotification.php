<?php

namespace App\Notifications\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ZipFileNotification extends Notification
{
    use Queueable;

    protected $job_id;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($job_id, $link)
    {
        $this->job_id = $job_id;
        $this->link = $link;
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
            'id' => $this->job_id,
            'title' => 'Jobs Zip File',
            'message' => 'Jobs Zip File Archive and Ready To Download',
            'url' => $this->link,
            'diff_time' => Date('Y-m-d H:i:s'),
            'module' => 'JOBS',
            'icon' => 'bi bi-file-zip text-success'
        ];
    }
}
