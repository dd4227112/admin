<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GlobalExam extends Model
{
    protected $table = 'constant.global_exams';
    
      protected $fillable = ['id', 'name', 'association_id','date', 'class_level_id'];

    public function association() {
        return $this->belongsTo('\App\Model\Association');
    }
}
