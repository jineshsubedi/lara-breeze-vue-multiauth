<?php

namespace Hris\Booking\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification
{
    use Queueable;

    protected $booking;
    protected $message;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking, $message, $link)
    {
        $this->booking = $booking;
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
            'id' => $this->booking->id,
            'title' => 'Invitation For Meeting',
            'message' => $this->message,
            'url' => $this->link,
            'diff_time' => $this->booking->created_at,
            'module' => 'BOOKING',
            'icon' => 'bi bi-calendar-check text-success'
        ];
    }
}
