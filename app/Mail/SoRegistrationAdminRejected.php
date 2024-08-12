<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SoRegistrationAdminRejected extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $applicant_name;
    public $remark;
    public $so_name;
    public function __construct($applicant_name,$remark,$so_name)
    {
        //
        $this->applicant_name = $applicant_name;
        $this->remark = $remark;
        $this->so_name = $so_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Membership Application Rejected',

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.so-registration-admin-rejected',
            with: [
                'applicant_name' => $this->applicant_name,
                'remark' => $this->remark,
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
