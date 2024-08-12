<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class ActivityEditNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $activityOwnerName;
    public $soName;
    public $activityTitle;
    public $changes; // Add property for changes

    /**
     * Create a new message instance.
     *
     * @param string $activityOwnerName
     * @param string $soName
     * @param string $activityTitle
     * @param array $changes // Add changes as an argument
     */
    public function __construct($activityOwnerName, $soName, $activityTitle, $changes)
    {
        $this->activityOwnerName = $activityOwnerName;
        $this->soName = $soName;
        $this->activityTitle = $activityTitle;
        $this->changes = $changes;
    }
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activity Edit Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.activity-edit',
            with: [
                'so_pres' => $this->activityOwnerName,
                'so_name' => $this->soName,
                'activityTitle' => $this->activityTitle,
                'changes' => $this->changes
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
