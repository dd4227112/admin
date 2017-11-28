<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PaymentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests() {
        $this->data['requests'] = \App\Request::latest()->paginate();
        return view('payment.api_requests', $this->data);
    }

    public function invoices() {
        $this->data['invoices'] = DB::table('api.invoices')->get();
        return view('payment.invoices', $this->data);
    }

    public function payment($school=null) {
        $this->data['schools']=DB::select("select distinct table_schema from information_schema.tables where table_schema not in ('admin','pg_catalog','information_schema','api','app')");
        if ($school !=null) {
            $this->data['payments'] = DB::table('admin.all_payment')->join($school.'.invoices','admin.all_payment.invoiceID',$school.'.invoices.id')->join($school.'.invoices','admin.all_payment.invoiceID',$school.'.invoices.id')->where('schema_name',$school)->get();
            //dd($this->data['payments']);
        }else{
            $this->data['payments'] = array();
        }
        return view('payment.payment', $this->data);
    }

}
