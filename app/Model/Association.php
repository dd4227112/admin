<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
      protected $table = 'constant.associations';
      
      public function globalExams() {
          return $this->hasMany('\App\Model\GlobalExam');
      }
}
