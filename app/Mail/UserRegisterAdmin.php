<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegisterAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $so_name;
    public $user;
    public $email;
    /**
     * Create a new message instance.
     */
    public function __construct($so_name,$user,$email)
    {
        //
        $this->so_name = $so_name;
        $this->user = $user;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation of Account Application for ' . $this->so_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.user-register-admin',
            with: [
                'so_name' => $this->so_name,
                'user' => $this->user,
                'email' => $this->email,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
