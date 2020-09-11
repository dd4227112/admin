<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingModule extends Model {

    /**
     * Generated
     */

    protected $table = 'admin.training_modules';
    protected $fillable = ['id', 'name', 'description', 'created_by','specialist_id','created_at','updated_at'];

    public function trainingSection() {
        return $this->hasMany(\App\Model\TrainingSection::class);
    }


}
