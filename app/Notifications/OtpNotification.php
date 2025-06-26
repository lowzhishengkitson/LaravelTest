<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsappChannel;
use App\Notifications\Messages\WhatsAppMessage;

class OtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return [WhatsappChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        return new WhatsAppMessage("Your WhatsApp OTP is: {$this->otp}");
    }
}
