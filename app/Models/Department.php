<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

    /**
     * Generated
     */

    protected $table = 'admin.departments';
    protected $fillable = ['id', 'name', 'note', 'created_at'];

}
