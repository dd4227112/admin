<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppMessages extends Model {

    protected $table = 'admin.whatsapp_messages';
    protected $fillable = ['id', 'message', 'phone', 'name', 'status', 'return_message', 'created_at', 'updated_at'];
}
