<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTracker extends Model {

   // use \App\Traits\BelongsToUser;


    protected $table = 'invoices_tracker';

    protected $fillable = ['id', 'invoice_id', 'prev_amount', 'new_amount', 'user_id', 'date','created_at','updated_at'];


    public function invoice() {
        return $this->belongsTo(\App\Models\Invoice::class, 'invoice_id', 'id');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

}
