<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Ticket;

class ConfirmationRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(Ticket $data){
      $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('noreply@adminespora.online')
                  ->view('emails.confirmreq');
    }
}
