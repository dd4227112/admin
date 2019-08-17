<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPension extends Model {

    /**
     * Generated
     */

    protected $table = 'user_pensions';
    protected $fillable = ['id', 'user_id', 'pension_id', 'created_by', 'checknumber'];


    public function constant.pension() {
        return $this->belongsTo(\App\Models\Constant.pension::class, 'pension_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }


}
