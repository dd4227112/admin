<?php 

namespace App\Traits;

trait belongsTocompanyFile {

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id')->withDefault(['name' => 'unknown']);
    }
}