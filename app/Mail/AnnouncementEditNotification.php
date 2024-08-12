<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AnnouncementEditNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pres;
    public $title;
    public $changes;
    /**
     * Create a new message instance.
     */
    public function __construct($pres, $title, $changes)
    {
        //
        $this->pres = $pres;
        $this->title = $title;
        $this->changes = $changes;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Announcement Edit Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.announcement-edit',
            with: [
                'pres' => $this->pres,
                'title' => $this->title,
                'changes' => $this->changes,
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
