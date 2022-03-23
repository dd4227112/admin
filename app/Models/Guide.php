<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{

    use \App\Traits\belongsTocompanyFile;

    protected $table = 'constant.guides';
    
    public $timestamps=false;
    protected $fillable = [
        'permission_id', 'content', 'created_by','language','company_file_id'
    ];
    
    public function permission() {
        return $this->belongsTo(\App\Model\Permissions::class);
    }

    public function createdBy() {
        return $this->belongsTo(\App\Models\User::class,'created_by','id')->withDefault(['firstname'=>'Not Defined','lastname'=>'Not Defined']);
    }
    
}
