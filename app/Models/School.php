<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model {

    /**
     * Generated
     */

    protected $table = 'schools';
    protected $fillable = ['id', 'region', 'district','ward','ownership','type','students','nmb_branch','ward_id'];

    public function users() {
        return $this->hasManyThrough(\App\Models\UsersSchool::class,\App\Models\User::class);
    }
    
    public function wards() {
        return $this->belongsTo(\App\Models\Ward::class, 'ward_id', 'id')->withDefault(['name' => 'Not Defined']);

    }

    public function contacts() {
        return $this->hasMany(\App\Models\SchoolContact::class);
    }
}
