<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSequence extends Model {

    /**
     * Generated
     */
    protected $table = 'users_sequences';
    protected $fillable = ['id', 'user_id', 'table', 'created_at', 'updated_at', 'schema_name', 'sequence_id'];

    public function sequence() {
        return $this->belongsTo(\App\Models\Sequence::class, 'sequence_id', 'id');
    }

    public function user() {
        return DB::table('admin.all_users')->where('schema_name', $this->attributes['schema_name'])->where('table', $this->attributes['table'])->where('id', $this->attributes['user_id'])->first();
    }

}
