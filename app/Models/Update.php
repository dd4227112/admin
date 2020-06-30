<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Update extends Model {

    /**
     * Generated
     */

    protected $table = 'updates';
    protected $fillable = ['id', 'for', 'message', 'update_type', 'released_date', 'created_by', 'version'];



}
