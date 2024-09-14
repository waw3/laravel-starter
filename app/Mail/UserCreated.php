<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * $user
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * $options
     *
     * @var mixed
     */
    public $options;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $options = null)
    {
        $this->user = $user;
        $this->options = $options;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'User Created',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.user_created',
            with: [
                'user' => $this->user,
                'options' => $this->options,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
