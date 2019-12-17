<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'firstname', 'lastname', 'phone', 'created_by', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function name() {
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }

    public function location() {
        return $this->hasMany('App\Model\Location');
    }

    public function location_str() {
        $loc = $this->location()->first();
        if (empty($loc))
            return '';
        return $loc->long . ", " . $loc->lat;
    }

    public function role() {
        return $this->belongsTo('App\Model\Role')->withDefault(['display_name' => 'unknown']);
    }

    public function usersSchools() {
        return $this->hasMany(\App\Model\UsersSchool::class);
    }

}
