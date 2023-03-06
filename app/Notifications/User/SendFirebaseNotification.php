<?php

namespace App\Notifications\User;

use App\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendFirebaseNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $title, $message, $type = "From App", $type_id = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $message, $type = "From App", $type_id = null)
    {

        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->type_id = $type_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, 'database'];
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
            "title" => $this->title,
            "message" => $this->message,
            "type" => $this->type,
            "type_id" => $this->type_id,
        ];
    }

    public function toFcm($notifiable)
    {

        return (object) $this->toArray($notifiable);
    }
}
