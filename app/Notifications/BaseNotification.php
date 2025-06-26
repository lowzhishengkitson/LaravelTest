<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification
{
    /**
     * Determine channels based on the notifiable's preference.
     */
    public function via($notifiable)
    {
        // Default to mail if not set
        $channel = $notifiable->preferred_channel ?? 'mail';

        // Return as array, Laravel expects an array of channels
        return [$channel];
    }
}
