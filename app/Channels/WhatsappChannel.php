<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class WhatsappChannel
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('whatsapp'))
            return;

        $message = $notification->toWhatsapp($notifiable);

        $to = $notifiable->routeNotificationFor('Whatsapp');

        $options = [
            'from' => config('services.twilio.from_whatsapp'),
            "body" => $message->content,
        ];

        if (!empty($message->mediaUrl))
        {
            $options['mediaUrl'] = [$message->mediaUrl];
            logger("Message url: " . $options['mediaUrl'][0]);
        }

        try
        {
            $result = $this->twilio->messages->create("whatsapp:$to", $options);
        }
        catch (\Exception $e)
        {
            logger("Twilio WhatsApp send error: " . $e->getMessage());
        }
    }
}
