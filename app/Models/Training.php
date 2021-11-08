<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model {

    /**
     * Generated
     */

    protected $table = 'admin.trainings';
    protected $fillable = ['id', 'title', 'module','created_at','updated_at'];

    public function trainItems() {
      return $this->hasMany(\App\Models\TrainItem::class, 'training_id', 'id');
    }

}
