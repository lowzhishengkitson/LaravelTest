<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsappService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function sendViaWhatsApp($to, $message)
    {
        $this->twilio->messages->create("whatsapp:$to", [
            'from' => config('services.twilio.from_whatsapp'),
            'body' => $message
        ]);
    }
}
