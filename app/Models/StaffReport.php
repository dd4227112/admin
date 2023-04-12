<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffReport extends Model {

    /**
     * Generated
     */

    public $table = 'shulesoft.staff_report';
    protected $primaryKey = 'id';
    protected $fillable = ['id','user_sid','user_id','user_table', 'date', 'comment', 'title', 'attach', 'attach_file_name','status', 'schema_name'];

    public function user() {
        return $this->belongsTo(\App\Model\User::class, 'user_sid', 'sid');
    }

    
}
