<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyBonus extends Model {

    protected $table = 'monthly_bonus';
    protected $fillable = ['id', 'user_id', 'bonus_amount', 'created_at','updated_at','name','role_id','date','school_id'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }



}
