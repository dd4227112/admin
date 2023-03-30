<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxTable extends Model {

    /**
     * Generated
     */
    protected $table = 'constant.tax_status';
    protected $fillable = ['id', 'name', 'start_date', 'end_date', 'created_at'];

    public function payes() {
        return $this->hasMany(\App\Models\Paye::class, 'tax_status_id', 'id');
    }
}
