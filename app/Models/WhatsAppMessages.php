<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppMessages extends Model {

  //  use \App\Traits\belongsTocompanyFile;


    protected $table = 'admin.whatsapp_messages';

    protected $fillable = ['id', 'message', 'phone', 'name', 'status', 'return_message', 'created_at', 'updated_at','company_file_id', 'project'];
   
    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id')->withDefault(['name' => 'unknown']);
    }

}
