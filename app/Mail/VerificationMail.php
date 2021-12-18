<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $detail;

    public function __construct($detail)
    {
        
        $this->detail = $detail;
    }

    public function build()
    {
        return $this->view('view.name');
        return $this->subject('190710501')->view('mail');
    }
}