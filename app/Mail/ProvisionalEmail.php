<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProvisionalEmail extends Mailable
{
    private $send_item;

    public function __construct($send_item)
    {
        $this->send_item = $send_item;
    }

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this ->from('demo@example.com')
          ->subject('テスト送信')
          ->view('mail.provision')
          ->with(['send_item' => $this->send_item]);
    }
}
