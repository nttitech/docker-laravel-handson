<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

define('SUBJECT', '[パスワード再設定用URLの送信]');

class ResetURL extends Mailable
{
    use Queueable, SerializesModels;

    protected  $reset_password;

    public function __construct($reset_password)
    {
        $this->reset_password = $reset_password;
    }

    public function build()
    {
        $reset_url = 'http://localhost:8080/api/reset_password/url?reset_password=' . $this->reset_password;

        return $this->from('takahironakagawa2015@gmail.com')
                    ->subject(SUBJECT)
                    ->view('mails.reseturl', compact('reset_url'));

    }
}
