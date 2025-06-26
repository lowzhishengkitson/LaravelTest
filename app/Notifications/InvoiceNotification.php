<?php

namespace App\Notifications;

use App\Channels\WhatsappChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Notifications\Messages\WhatsAppMessage;

class InvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public ?string $mediaUrl = null;

    public function __construct($mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;
    }

    public function via(object $notifiable): array
    {
        return [WhatsappChannel::class];
    }

    public function toWhatsapp(object $notifiable): WhatsAppMessage
    {
        return new WhatsAppMessage('Your new invoice is ready.', $this->mediaUrl);
    }
}
