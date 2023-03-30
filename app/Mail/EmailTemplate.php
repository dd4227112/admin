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
    public $email_to;
    public $content;
    public $school;
    public $contact;

  
    public function __construct($data = array())
    {
         $this->title   = $data['subject'];
         $this->email_to = $data['email_to'];
         $this->content = $data['content'];
         $this->school  = $data['school'];
         $this->contact  = $data['contact'];
    }

    public function build()
    { 
        return $this->view('emails.emailTemplate')->to($this->email_to)->subject($this->title)
        ->with(['content' => $this->content,'school' => $this->school,'contact' => $this->contact,'email_to' => $this->email_to]);
    }
}
