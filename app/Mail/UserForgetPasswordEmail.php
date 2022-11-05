<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserForgetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected String $code;
    protected User $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'User Forget Password Email',
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
            markdown: 'mail.user-forget-password-email',
            with: [
                'code' => $this->code,
                'name' => $this->user->name
            ]
        );
    }

    // public function build()
    // {
    //     return $this->with(
    //         [
    //             'code' => $this->code,
    //             'name' => $this->user->name
    //         ]
    //     )->markdown('mail.user-forget-password-email');
    // }

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
