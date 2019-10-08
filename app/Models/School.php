<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model {

    /**
     * Generated
     */

    protected $table = 'schools';
    protected $fillable = ['id', 'region', 'district','ward','ownership','type'];

    public function users() {
        return $this->hasManyThrough(\App\Models\UsersSchool::class,\App\Models\User::class);
    }

}
