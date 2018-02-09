<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
     protected $table = 'api.requests';
     public $timestamps=false;
}
