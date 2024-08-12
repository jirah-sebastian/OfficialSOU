<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SoRegistrationAdminApproval extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $applicant_name;
    public $applicant_email;
    public $applicant_position;
    public $created_at;
    public $so_pres;
    public $so_name;
    public function __construct($applicant_name, $applicant_email, $applicant_position, $created_at,$so_pres,$so_name)
    {
        //
        $this->applicant_name     = $applicant_name;
        $this->applicant_email    = $applicant_email;
        $this->applicant_position = $applicant_position;
        $this->created_at         =  $created_at;
        $this->so_pres = $so_pres;
        $this->so_name = $so_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Membership Application for Review',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.so-registration-admin-approval',
            with: [
                'applicant_name'=> $this->applicant_name,
                'applicant_email'=> $this->applicant_email,
                'applicant_position'=> $this->applicant_position,
                'created_at'  => $this->created_at,
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
