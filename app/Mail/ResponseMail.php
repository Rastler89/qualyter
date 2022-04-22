<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $body;

    public function __construct($body) {
        $this->body = $body;
    }

    public function build() {
        return $this->from('qc@optimaretail.es')
                    ->subject(__('New answer!'))
                    ->view('emails.response');
    }
}