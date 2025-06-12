<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationVerificationNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from($address = "no-reply@test.id", $name = "RKC-MPD ERIA")
        ->subject("Welcome to ERIA’s Private Sector Platform. Please Verify Your Email")
        ->view('email.user-verification-registration-notification');
    }
}
