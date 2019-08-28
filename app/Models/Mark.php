<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model {

    /**
     * Generated
     */

    protected $table = 'marks';
     protected $primaryKey = 'id';
     public $timestamps=false;
    protected $fillable = ['id', 'name', 'subject_name', 'subject_id', 'roll', 'name', 'subject_id', 'mark', 'global_exam_id', 'refer_class_id', 'student_status', 'created_at', 'updated_at','sex','region','schema_name'];


    public function globalExam() {
        return $this->belongsTo(\App\Models\GlobalExam::class, 'global_exam_id', 'id');
    }

    public function referClass() {
        return $this->belongsTo(\App\Models\ReferClass::class, 'refer_class_id', 'id');
    }

    public function subject() {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id', 'id');
    }


}
