<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSent extends Model {

    use \App\Traits\BelongsToUser;


    /**
     * Generated
     */

    protected $table = 'invoices_sent';
    protected $fillable = ['id', 'user_id', 'amount', 'student', 'schema_name', 'date', 'created_at','email','phone_number','message'];


}
