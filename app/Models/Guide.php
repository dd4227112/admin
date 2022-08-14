<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{

   // use \App\Traits\belongsTocompanyFile;

    protected $table = 'constant.guides';
    
    public $timestamps=false;
    protected $fillable = [
        'permission_id', 'content', 'created_by','language','company_file_id'
    ];
    
    public function permission() {
        return $this->belongsTo(\App\Models\Permission::class);
    }

    public function createdBy() {
        return $this->belongsTo(\App\Models\User::class,'created_by','id')->withDefault(['firstname'=>'Not Defined','lastname'=>'Not Defined']);
    }


    public function guidePageVisit() {
        return $this->hasMany(\App\Models\GuidePageVisit::class);
    }


    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id')->withDefault(['name' => 'unknown']);
    }
    
}