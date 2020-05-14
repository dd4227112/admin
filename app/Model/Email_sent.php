<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Email_sent extends Model
{
     protected $table = 'sent_emails';
    protected $primaryKey = 'id';
}
