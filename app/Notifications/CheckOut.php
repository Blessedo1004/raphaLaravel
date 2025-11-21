<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class CheckOut extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct( \App\Models\ActiveReservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'user_name' => $this->reservation->user->first_name,
        ];
    }
}
