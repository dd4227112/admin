<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.schools';
    protected $fillable = ['id','name','ownership','type','students','ward_id','zone','nmb_school_name','nmb_zone',
    'branch_code','branch_name','account_number','schema_name','nmb_branch','country_id','status','registered'];

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
