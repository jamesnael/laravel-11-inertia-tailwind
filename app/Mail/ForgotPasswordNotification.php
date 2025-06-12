<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class ForgotPasswordNotification extends Mailable
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
     */
    public function build()
    {
        return $this
        ->from($address = "no-reply@test.id", $name = "RKC-MPD ERIA")
        ->subject("Password Reset Confirmation")
        ->view('email.forgot-password')
        ->with([
            'data' => $this->data,
            'token' => Crypt::encryptString($this->data->id .'-'. $this->data->forgot_password_token)
        ]);
    }
}
