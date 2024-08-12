<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AnnouncementNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pres;
    public $title;
    public $content;
    /**
     * Create a new message instance.
     */
    public function __construct($pres, $title, $content)
    {
        //
        $this->pres =$pres;
        $this->title =$title;
        $this->content =$content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Announcement Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.announcement',
            with: [
                'pres' =>$this->pres,
                'title'=>$this->title,
                'content'=>$this->content,
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