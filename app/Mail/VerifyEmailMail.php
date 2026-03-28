<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $verificationUrl;
    public string $userName;

    public function __construct(string $verificationUrl, string $userName)
    {
        $this->verificationUrl = $verificationUrl;
        $this->userName        = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Verifikasi Email - HDS Dental Clinic');
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.verify-email',
            with: [
                'verificationUrl' => $this->verificationUrl,
                'userName'        => $this->userName,
            ],
        );
    }
}