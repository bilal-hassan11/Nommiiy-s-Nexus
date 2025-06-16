<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $roleName;
    public $plainPassword;


    public function __construct($user, $roleName, $plainPassword) // Accept plain password in the constructor
    {
        $this->user = $user;
        $this->roleName = $roleName; // Assign role name to the property
        $this->plainPassword = $plainPassword; // Assign plain password to the property
    }
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    { 
        return new Content(
            view: 'emails.user-created',
            with: [
                'user' => $this->user, // Pass user to the view
                'roleName' => $this->roleName, // Pass role name to the view
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
