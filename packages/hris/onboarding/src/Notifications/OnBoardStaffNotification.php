<?php

namespace Hris\Onboarding\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OnBoardStaffNotification extends Notification
{
    use Queueable;

    protected $staff;
    protected $message;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($staff, $message, $link)
    {
        $this->staff = $staff;
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
            'id' => $this->staff->id,
            'title' => $this->staff->name.' [Onboarding Staff]',
            'message' => $this->message,
            'url' => $this->link,
            'diff_time' => $this->staff->updated_at,
            'module' => 'ONBOARD',
            'icon' => 'bi bi-box-seam text-success'
        ];
    }
}
