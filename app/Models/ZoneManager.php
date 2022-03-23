<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneManager extends Model {

    use \App\Traits\BelongsToUser;
    
    /**
     * Generated
     */
    protected $table = 'admin.zone_managers';
    protected $fillable = ['id', 'zone_id', 'user_id', 'created_at', 'updated_at'];
    
    public function zone() {
        return $this->belongsTo(\App\Models\Zone::class, 'zone_id', 'id');
    }

}
