<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalContract extends Model {

  //  use \App\Traits\BelongsToUser;
  //  use \App\Traits\belongsTocompanyFile;

    protected $table = 'legal_contracts';
    protected $fillable = ['id', 'name','start_date','end_date','user_id','company_file_id','description','updated_at'];

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id')->withDefault(['name' => 'unknown']);
    }

}