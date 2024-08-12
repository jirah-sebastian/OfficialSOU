<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class UserEditNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $userName;
    public $changes;

   
    public function __construct($userName, $changes)
    {
        $this->userName = $userName;
        $this->changes = $changes;
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Edit Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.user-edit',
            with: [
                'userName' => $this->userName,
                'changes' => $this->changes
            ]
        );
        
    }

    public function attachments(): array
    {
        return [];
    }
}
