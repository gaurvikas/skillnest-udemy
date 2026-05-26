<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Contact $contact,
        protected string $replyMessage,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Re: '.($this->contact->subject ?: 'Your message to SkillNest'))
            ->view('frontend.pages.mail.contact-reply', [
                'contact' => $this->contact,
                'replyMessage' => $this->replyMessage,
            ]);
    }
}
