<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SOEditNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $soPres;
    public $soName;
    public $changes;
    
    /**
     * Create a new message instance.
     */
    public function __construct($soPres, $soName, $changes)
    {
        $this->soPres = $soPres;
        $this->soName = $soName;
        $this->changes = $changes;
    }

    /**
     * Get the message envelope.
     */

     public function envelope(): Envelope
     {
         return new Envelope(
             subject: 'SO Edit Notification',
         );
     }
    public function build()
    {
        return $this
            ->subject('SO Edit Notification')
            ->view('mail.v2.so-edit')
            ->with([
                'soPres' => $this->soPres,
                'soName' => $this->soName,
                'changes' => $this->changes,
            ]);
    }
}
