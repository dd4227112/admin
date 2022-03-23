<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAllowance extends Model {
   
    use \App\Traits\BelongsToUser;

    /**
     * Generated
     */

    protected $table = 'user_allowances';
    protected $fillable = ['id', 'user_id', 'allowance_id', 'created_by', 'deadline', 'type', 'amount', 'percent'];


    public function allowance() {
        return $this->belongsTo(\App\Models\Allowance::class, 'allowance_id', 'id');
    }


}
