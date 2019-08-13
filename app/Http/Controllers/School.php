<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class School extends Controller {
    
    public $school;
    
    public function __construct($schema_name=null){
        $this->school=$schema_name;
    }
    
    
}
