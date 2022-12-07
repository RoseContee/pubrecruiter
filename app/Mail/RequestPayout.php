<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestPayout extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        $from_email = $this->data['from_email'];
        $from_name = "{$this->data['site_name']} Creator Partnerships";
        return $this->from($from_email, $from_name)
            ->subject("Payout Request - {$this->data['name']}")
            ->view('mail.request-payout', [
                'data' => $this->data,
            ]);
    }
}
