<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model {

    /**
     * Generated
     */
    protected $table = 'slots';
    protected $fillable = ['id', 'start_time', 'end_time', 'activity', 'status', 'created_at', 'updated_at'];

    public function task() {
        return $this->hasMany(\App\Models\Task::class);
    }

}
