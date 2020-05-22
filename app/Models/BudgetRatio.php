<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetRatio extends Model {

    /**
     * Generated
     */

    protected $table = 'budget_ratios';
    protected $fillable = ['id', 'name', 'percent', 'project_id'];


    public function project() {
        return $this->belongsTo(\App\Models\Project::class);
    }

}
