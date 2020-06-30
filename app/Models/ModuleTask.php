<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleTask extends Model {

    /**
     * Generated
     */

    protected $table = 'module_tasks';
    protected $fillable = ['id', 'module_id', 'task_id', 'created_at'];


    public function subModule() {
        return $this->belongsTo(\App\Models\SubModule::class, 'module_id', 'id');
    }

    public function task() {
        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
    }

}
