<?php

namespace App\Http\Controllers\Lineshop;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use \App\Models\UserAllowance;
use App\Models\SalaryAllowance;

class Sales extends Controller {
    function __construct() {
        $this->middleware('auth');
       $this->data['insight'] = $this;
   }
public function salesMaterials(){
    echo "salesMaterials";
    exit;
}
public function pharmacies(){
        $id = request()->segment(3);
        $reg_id = request()->segment(4);
        dd($id);


}
public function pharmacyRequest(){
    echo "pharmacyRequest";
    exit;
}
}