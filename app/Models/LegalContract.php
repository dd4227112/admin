<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalContract extends Model {

    protected $table = 'legal_contracts';
    protected $fillable = ['id', 'name','start_date','end_date','user_id','company_file_id','description','updated_at'];

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

}