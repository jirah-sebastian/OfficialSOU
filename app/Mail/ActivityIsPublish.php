<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Activity;
class ActivityIsPublish extends Mailable
{
    use Queueable, SerializesModels;
    public Activity $activity;
    public $so_pres;
    public $so_name;
    /**
     * Create a new message instance.
     */
    public function __construct(Activity $activity,$so_pres,$so_name)
    {
        //
        $this->activity = $activity;
        $this->so_pres = $so_pres;
        $this->so_name = $so_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Activity Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.activity-is-publish',
            with:[
                'activity' => $this->activity,
                'so_pres' => $this->so_pres,
                'so_name' => $this->so_name
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