<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model {

    /**
     * Generated
     */

    protected $table = 'schools';
    protected $fillable = ['id', 'region', 'district','ward','ownership','type','students','nmb_branch'];

    public function users() {
        return $this->hasManyThrough(\App\Models\UsersSchool::class,\App\Models\User::class);
    }

    public function contacts() {
        return $this->hasMany(\App\Models\SchoolContact::class);
    }
}
