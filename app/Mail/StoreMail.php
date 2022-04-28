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
        $date = date('d-m-y');

        return $this->from('qc@optimaretail.es')
                    ->subject($date.' '.__('mantenimiento').' - Optima Retail')
                    ->locale($this->body['locale'])
                    ->view('emails.store');
    }
}