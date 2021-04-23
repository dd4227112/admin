<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model {

    protected $table = 'budgets';
    protected $fillable = ['id', 'created_by', 'amount', 'description'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

}
