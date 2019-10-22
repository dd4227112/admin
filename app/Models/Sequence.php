<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sequence extends Model {

    /**
     * Generated
     */

    protected $table = 'sequences';
    protected $fillable = ['id', 'title', 'message', 'interval', 'created_at','updated_at'];


}
