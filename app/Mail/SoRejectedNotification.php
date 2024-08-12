<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SoRejectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $so;
    public $pres;
    public $position;
    /**
     * Create a new message instance.
     */
    public function __construct($applicant,$so,$pres,$position)
    {
        //
        $this->applicant = $applicant;
        $this->so = $so;
        $this->pres = $pres;
        $this->position = $position;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ' Membership Application Rejected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.so-rejected',
            with: [
                'applicant' => $this->applicant,
                'so' => $this->so,
                'pres' => $this->pres,
                'position' => $this->position,
             ],
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
