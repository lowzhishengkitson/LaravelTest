<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioVerifyService
{
    protected $twilio;
    protected $verifySid;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->verifySid = config('services.twilio.verify_sid');
    }

    public function sendOtp($to, $channel = 'sms') // or 'whatsapp'
    {
        return $this->twilio->verify->v2->services($this->verifySid)
            ->verifications
            ->create($to, $channel); // +6591234567, 'sms' or 'whatsapp'
    }

    public function checkOtp($to, $code)
    {
        return $this->twilio->verify->v2->services($this->verifySid)
            ->verificationChecks
            ->create([
                'to' => $to,
                'code' => $code,
            ]);
    }
}
