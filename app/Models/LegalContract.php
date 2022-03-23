<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalContract extends Model {

    use \App\Traits\BelongsToUser;
    use \App\Traits\belongsTocompanyFile;

    protected $table = 'legal_contracts';
    protected $fillable = ['id', 'name','start_date','end_date','user_id','company_file_id','description','updated_at'];



}