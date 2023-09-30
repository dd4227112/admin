<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LineshopRequirement extends Model {

    //use \App\Traits\BelongsToUser;

    //put your code here 
    protected $table = 'lineshop_requirements';

    protected $fillable = ['id', 'note','priority', 'user_id', 'contact', 'created_at', 'updated_at', 'to_user_id', 'project_id', 'module_id', 'due_date', 'school_id', 'status','user_sid'];

  

    public function toUser() {
        return $this->belongsTo(\App\Models\User::class, 'to_user_id', 'id')->withDefault(['name' => 'Not allocated']);
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

    
    public function pharmacy() {
        return $this->belongsTo(\App\Models\Pharmacies::class, 'pharmacy_id', 'id')->withDefault(['name' => 'Not Defined']);
    }

    public function modules() {
        return $this->hasMany(\App\Models\ModuleTask::class, 'task_id', 'id');
    }

}

