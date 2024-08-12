<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SoListApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $so_pres;
    public $so_name;
    public $email;
    public $date;
    /**
     * Create a new message instance.
     */
    public function __construct($so_pres,$so_name,$email,$date)
    {
        //
        $this->so_pres = $so_pres;
        $this->so_name = $so_name;
        $this->email = $email;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Student Organization Approved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.so-list-approved',
            with: [
                'so_pres' => $this->so_pres,
                'so_name' => $this->so_name,
                'email' => $this->email,
                'date' => $this->date,
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
