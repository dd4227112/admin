<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsentReason extends Model {

    /**
     * Generated
     */

    protected $table = 'absent_reasons';
    protected $fillable = ['id', 'name','created_at','updated_at'];


}
