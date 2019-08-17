<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    /**
     * Generated
     */

    protected $table = 'invoices';
    protected $fillable = ['id', 'reference', 'client_id', 'title', 'optional_name', 'date', 'status', 'year', 'active', 'sync', 'return_message', 'push_status', 'note', 'type', 'currency', 'user_id'];


    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function invoiceFees() {
        return $this->hasMany(\App\Models\InvoiceFee::class, 'invoice_id', 'id');
    }

    public function payments() {
        return $this->hasMany(\App\Models\Payment::class, 'invoice_id', 'id');
    }


}
