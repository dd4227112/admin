<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uattendance extends Model {

    use \App\Traits\BelongsToUser;

    /**
     * Generated
     */
    protected $table = 'uattendances';
    protected $fillable = ['id', 'user_id', 'created_by', 'date', 'timein', 'timeout', 'present', 'absent_reason', 'source', 'absent_reason_id'];

    public function absentReason() {
        return $this->belongsTo(\App\Models\AbsentReason::class, 'absent_reason_id', 'id');
    }


}
