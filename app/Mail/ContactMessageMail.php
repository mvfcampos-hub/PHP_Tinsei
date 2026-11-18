<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contact) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Site Tinsei — '.(ContactMessage::SUBJECTS[$this->contact->subject_type] ?? 'Contato').' — '.$this->contact->name,
            replyTo: [$this->contact->email],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.contact-message');
    }
}
