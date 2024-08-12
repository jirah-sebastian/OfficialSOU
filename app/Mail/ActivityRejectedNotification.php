<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivityRejectedNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $so_pres;
    public $so_name;
    public $remarks;
    public $activityTitle;
    /**
     * Create a new message instance.
     */
    public function __construct($so_pres,$so_name,$remarks,$activityTitle )
    {
        //
        $this->so_pres = $so_pres;
        $this->so_name = $so_name;
        $this->remarks = $remarks;
        $this->activityTitle = $activityTitle;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activity Rejected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.activity-rejected',
            with: [
                'so_pres' => $this->so_pres,
                'so_name' => $this->so_name,
                'remarks' => $this->remarks,
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