<?php

namespace App\Notifications\Messages;

class WhatsAppMessage
{
    public string $content;
    public ?string $mediaUrl = null;

    public function __construct(string $content, ?string $mediaUrl = null)
    {
        $this->content = $content;
        $this->mediaUrl = $mediaUrl;
    }

    public function media(string $url): self
    {
        $this->mediaUrl = $url;
        return $this;
    }
}
