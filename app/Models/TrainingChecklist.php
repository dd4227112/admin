<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingChecklist extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.training_checklist';
    protected $fillable = ['id', 'title', 'position', 'page_section', 'key_columns', 'key_table', 'created_by', 'training_section_id', 'created_at', 'updated_at'];

    public function trainingSection() {
        return $this->belongsTo(\App\Model\TrainingSection::class);
    }

    public function training() {
        return $this->hasMany(\App\Model\Training::class);
    }

}
