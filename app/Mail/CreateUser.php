<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateUser extends Mailable
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
        $from_name = $this->data['site_name'];
        if ($this->data['user_type'] == 'Brand') {
            return $this->from($from_email, $from_name)
                ->subject('Welcome to Pub Recruiter – Start Finding Partnerships!')
                ->view('mail.creation-brand', [
                    'data' => $this->data,
                ]);
        }
        return $this->from($from_email, $from_name)
            ->subject('Complete Your Profile! (Welcome to Pub Recruiter)')
            ->view('mail.creation-creator', [
                'data' => $this->data,
            ]);
    }
}
