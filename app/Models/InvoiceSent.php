<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSent extends Model {

    /**
     * Generated
     */

    protected $table = 'invoices_sent';
    protected $fillable = ['id', 'user_id', 'amount', 'student', 'schema_name', 'date', 'created_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

}
