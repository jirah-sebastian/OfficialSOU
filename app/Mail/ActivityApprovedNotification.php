<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivityApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $pres;
    public $so;
    public $activityTitle;
    /**
     * Create a new message instance.
     */
    public function __construct($so_pres,$so_name,$activityTitle)
    {
        //
        $this->so_pres = $so_pres;
        $this->so_name = $so_name;
        $this->activityTitle = $activityTitle;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activity Approved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.activity-approved',
            with: [
                'so_pres' => $this->so_pres,
                'so_name' => $this->so_name,
                'activityTitle' => $this-> activityTitle
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