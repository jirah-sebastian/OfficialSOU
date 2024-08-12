<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivityProposalNotification extends Mailable
{
    use Queueable, SerializesModels;
    
    public $activity_title;
    public $event_date;
    public $content;
    public $so_name;
    public $so_category; // Add this property
    public $sub_title; // Add this property
    public $event_place; // Add this property
    public $type_of_activity; // Add this property
    public $sustainable_development_goal; // Add this property
    public $gad_funded; // Add this property

    /**
     * Create a new message instance.
     */
    public function __construct($activity_title, $event_date, $content, $so_name, $so_category, $sub_title, $event_place, $type_of_activity, $sustainable_development_goal, $gad_funded)
    {
        //
        $this->activity_title = $activity_title;
        $this->event_date = $event_date;
        $this->content = $content;
        $this->so_name = $so_name;
        $this->so_category = $so_category; // Assign the new properties
        $this->sub_title = $sub_title;
        $this->event_place = $event_place;
        $this->type_of_activity = $type_of_activity;
        $this->sustainable_development_goal = $sustainable_development_goal;
        $this->gad_funded = $gad_funded;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activity Proposal Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.v2.activity-proposal',
            with: [
                'activity_title' => $this->activity_title,
                'event_date' => $this->event_date,
                'content' => $this->content,
                'so_name' => $this->so_name,
                'so_category' => $this->so_category, // Pass the new properties to the view
                'sub_title' => $this->sub_title,
                'event_place' => $this->event_place,
                'type_of_activity' => $this->type_of_activity,
                'sustainable_development_goal' => $this->sustainable_development_goal,
                'gad_funded' => $this->gad_funded,
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
