<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
 
    protected $connection = 'biotime';
    protected $table = 'users';
    protected $fillable = ['id', 'name','email','phone'];

}
