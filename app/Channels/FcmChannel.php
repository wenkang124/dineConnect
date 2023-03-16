<?php

namespace App\Channels;

use App\Traits\Helpers;
use Illuminate\Notifications\Notification;

class FcmChannel
{
    use Helpers;

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $fcm_message = $notification->toFcm($notifiable);

        $tokens = $notifiable->fcm_token;
        $this->__sendFirebaseCloudMessagingToken($tokens, $notification->id, $fcm_message->type, $fcm_message->title, $fcm_message->message, $fcm_message->type_id ?? null,  false,  1,  null, null, true, null);
    }
}
