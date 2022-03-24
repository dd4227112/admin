<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model {

    use \App\Traits\BelongsToUser;

    protected $table = 'budgets';
    protected $fillable = ['id', 'created_by', 'amount', 'description'];

}
