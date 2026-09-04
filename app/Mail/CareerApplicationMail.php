<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CareerApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $application, public ?string $resumePath = null)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Trabalhe Conosco — '.$this->application['area'].' — '.$this->application['name'],
            replyTo: [$this->application['email']],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.career-application');
    }

    public function attachments(): array
    {
        if (! $this->resumePath) {
            return [];
        }

        return [
            \Illuminate\Mail\Mailables\Attachment::fromPath($this->resumePath)
                ->as($this->application['resume_name'] ?? 'curriculo'),
        ];
    }
}
