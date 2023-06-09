<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department_task extends Model
{
    use HasFactory;
    protected $table ='admin.department_tasks';
    protected $fillable =[
        'department_id', 'name', 'content', 'created_by', 'created_at', 'updated_at'
    ];
    public function department(){
        return $this->belongsTo(\App\Models\Department::class, 'department_id', 'id');
    }
    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
