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
    public $emai_to;
    public $content;
    public $school;
    public $phone;

  
    public function __construct($data = array())
    {
         $this->title   = $data['subject'];
         $this->emai_to = $data['emai_to'];
         $this->content = $data['content'];
         $this->school  = $data['school'];
         $this->phone  = $data['phone'];
    }

    public function build()
    { 
        return $this->view('emails.emailTemplate')->to($this->emai_to)->subject($this->title)
        ->with(['content' => $this->content,'school' => $this->school,'phone' => $this->phone,'emai_to' => $this->emai_to]);
    }
}
