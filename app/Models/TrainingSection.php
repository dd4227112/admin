<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TrainingSection extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.training_sections';
    protected $fillable = ['id', 'title', 'position', 'created_by', 'training_module_id', 'created_at', 'updated_at','timeslot'];

    public function trainingModule() {
        return $this->belongsTo(\App\Model\TrainingModule::class);
    }

    public function trainingChecklist() {
        return $this->hasMany(\App\Model\TrainingChecklist::class);
    }

}
