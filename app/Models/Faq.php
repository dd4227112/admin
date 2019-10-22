<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model {

    /**
     * Generated
     */

    protected $table = 'faq';
    protected $fillable = ['id', 'question', 'answer', 'created_by', 'table'];



}
