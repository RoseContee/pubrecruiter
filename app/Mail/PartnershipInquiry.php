<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnershipInquiry extends Mailable
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
        //Brand to Creator
        if ($this->data['user_type'] == 'Brand') {
            return $this->from($from_email, $from_name)
                ->subject("New Partnership Inquiry from {$this->data['name']}")
                ->view('mail.partnership-inquiry-brand', [
                    'data' => $this->data,
                ]);
        //Creator to Brand
        } else if ($this->data['user_type'] == 'Creator') {
            return $this->from($from_email, $from_name)
                ->subject("New Creator Partnership Inquiry: {$this->data['name']}")
                ->view('mail.partnership-inquiry-creator', [
                    'data' => $this->data,
                ]);
        //Opportunity to Creator
        } else {
            return $this->from($from_email, $from_name)
                ->subject("{$this->data['name']} :: {$this->data['creator']} Placement Opportunity")
                ->view('mail.opportunity-inquiry', [
                    'data' => $this->data,
                ]);
        }
    }
}
