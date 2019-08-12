<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Account extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $this->data['users'] = [];
        // $this->data['log_graph'] = $this->createBarGraph();
        return view('analyse.index', $this->data);
    }

    public function projection() {
        $this->data['budget'] = [];
        return view('account.projection', $this->data);
    }

    public function invoice() {
        $this->data['budget'] = [];
        $from = $this->data['from'] = request('from');
        $to = $this->data['to'] = request('to');
        $from_date = date('Y-m-d H:i:s', strtotime($from . ' -1 day'));
        $to_date = date('Y-m-d H:i:s', strtotime($to . ' +1 day'));
        $this->data['invoices'] = ($from != '' && $to != '') ?
                Invoice::whereBetween('date', [$from_date, $to_date])->where('type', 0)->get() :
                Invoice::where('type', 0)->get();
        return view('account.invoice', $this->data);
    }

}
