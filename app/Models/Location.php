<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    use \App\Traits\BelongsToUser;


    /**
     * Generated
     */

    protected $table = 'locations';
    protected $fillable = ['id', 'long', 'lat', 'user_id'];


}
