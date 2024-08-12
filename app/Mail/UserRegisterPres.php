<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegisterPres extends Mailable
{
    use Queueable, SerializesModels;
    public $so_pres;
    public $so_name;
    /**
     * Create a new message instance.
     */
    public function __construct($so_pres,$so_name)
    {
        //
        $this->so_pres=$so_pres;
        $this->so_name=$so_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application for Account Approval for ' .$this->so_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.user-register-pres',
            with: [
               'so_pres' => $this->so_pres,
               'so_name' => $this->so_name,
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
