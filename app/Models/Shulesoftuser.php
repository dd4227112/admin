<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Scopes\SchemaScope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Shulesoftuser extends Authenticatable {

    use Notifiable;

    protected $guarded = [];
    protected $primaryKey = 'sid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'shulesoft.users';
    protected $fillable = [
        'name', 'email', 'salary', 'password', 'username', 'phone', 'sid', 'table', 'id', 'payroll_status', 'fcm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    public $timestamps = false;

    public function getTableName() {
        return $this->attributes['table'];
    }

    public function userInfo($query) {
        $table = $this->attributes['table'] == 'student' ? 'student_id' : $this->attributes['table'] . 'ID';
        return $query->where($table, $this->attributes['id'])->first();
    }

    public function pension() {
        return $this->hasMany('App\Models\User_pension');
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function tourUser() {
        return $this->hasMany('App\Models\Tour_User');
    }

    public function uattendance() {
        return $this->hasMany(\App\Models\Uattendance::class, 'user_id', 'id');
    }

    public function roles() {
        return $this->belongsToMany(\App\Models\Role::class, \App\Models\UserRole::class, 'user_sid', 'role_id');
    }

    public function user_role() {
        return $this->belongsTo(\App\Models\UserRole::class, 'user_sid', 'sid');
    }

    public function notification() {
        return $this->hasMany('App\Models\UserNotification');
    }

    public function allowances() {
        return $this->hasMany(\App\Models\UserAllowance::class, 'user_sid', 'sid');
    }

    public function deductions() {
        return $this->hasMany(\App\Models\UserDeduction::class, 'user_sid', 'sid');
    }

    public function pensions() {
        return $this->hasMany(\App\Models\UserPension::class, 'user_sid', 'sid');
    }

    public function userDevices() {
        return $this->hasMany(\App\Models\UserDevice::class, 'user_sid', 'sid');
    }

    public function staffReports() {
        return $this->hasMany(\App\Models\StaffReport::class, 'user_sid', 'sid');
    }

    public function staffTargets() {
        return $this->hasMany(\App\Models\StaffTarget::class, 'user_sid', 'sid');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted() {
        static::addGlobalScope(new SchemaScope);
    }

}
