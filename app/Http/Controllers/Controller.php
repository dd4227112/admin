<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $data;

    public function createBarGraph() {
        $sql='select count(created_at::date), "user" as dataname,created_at::date as timeline from beta.log group by "user",created_at::date order by created_at::date desc limit 10';
        $this->data['results']=DB::select($sql);
        return view('graph.bargraph', $this->data);
    }
}
