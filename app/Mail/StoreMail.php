<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StoreMail extends Mailable
{
    use Queueable, SerializesModels;

    public $body;

    public function __construct($body) {
        $this->body = $body;
    }

    public function build() {
        $format = date_create($this->body['date']);
        $date = date_format($format,'Y-m-d');
        return $this->from('qc@optimaretail.es')
                    ->subject($date.' '.__('maintenance').' - Optima Retail')
                    ->view('emails.store');
    }
}