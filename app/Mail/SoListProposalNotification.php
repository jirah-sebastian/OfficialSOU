<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SoListProposalNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $so_name;
    public $so_pres;
    public $so_contact;
    /**
     * Create a new message instance.
     */
    public function __construct($so_name, $so_pres, $so_contact)
    {
        //
        $this->so_name= $so_name;
        $this->so_pres= $so_pres;
        $this->so_contact= $so_contact;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Student Organization Proposal Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.so-list-proposal',
            with: [
                'so_name' => $this->so_name,
                'so_pres' => $this->so_pres,
                'so_contact' => $this->so_contact,
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