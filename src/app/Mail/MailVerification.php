<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

define('MAIL_VERIFICATION_SUBJECT', '[メール認証コードの送信]');

class MailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected  $mail_authentication;

    public function __construct($mail_authentication)
    {
        $this->mail_authentication = $mail_authentication;
    }

    public function build()
    {
        $auth_url = 'http://localhost:8080/api/verify?mail_authentication=' . $this->mail_authentication;

        return $this->from('takahironakagawa2015@gmail.com')
                    ->subject(MAIL_VERIFICATION_SUBJECT)
                    ->view('mails.verification', compact('auth_url'));

    }
}
