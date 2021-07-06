<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $to;
    public $message;
    public $to_user;
  
    public function __construct($data = array())
    {
         $this->title   = $data['subject'];
         $this->emai_to = $data['emai_to'];
         $this->content = $data['content'];
         $this->to_user = $data['to_user'];
    }

    public function build()
    { 
        return $this->view('emails.emailTemplate')->to($this->emai_to,$this->to_user)->subject($this->title)->with(['content' => $this->content]);
    }
}
