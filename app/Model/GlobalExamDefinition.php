<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GlobalExamDefinition extends Model
{
    protected $table = 'constant.global_exam_definitions';
    public $timestamps=false;


    protected $fillable = ['id', 'name', 'association_id', 'school_level_id'];

    public function association() {
        return $this->belongsTo('\App\Model\Association')->withDefault(['name'=>'unknown']);
    }
    
     public function schoolLevel() {
        return $this->belongsTo('\App\Model\SchoolLevel');
    }
}
