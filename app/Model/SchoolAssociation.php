<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SchoolAssociation extends Model
{
      protected $table = 'admin.school_associations';
      
      public $timestamps=false;


      public function association() {
          return $this->belongsTo('\App\Model\Association');
      }
}
