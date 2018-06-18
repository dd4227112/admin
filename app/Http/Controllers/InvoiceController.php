<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class InvoiceController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return 1;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ((int) $id > 0) {
            $this->data['data'] = 1;
            $this->data['results'] = \App\Model\Api_invoice::where('id', $id)
                    ->where('schema_name', request('p'))->get();
            return view('home.invoice_search', $this->data);
        }else if($id=='searched'){
            $this->data['results']=DB::select("select * from api.invoices where lower(\"invoiceNO\") in (select lower(content->>'invoice') from admin.logs where content->>'invoice' is not null)");
             return view('invoice.searched', $this->data);
        }else {
        
            $sql = 'SELECT * FROM (SELECT * FROM public.crosstab(\'select "schema_name"::text,"table",count(*) from admin.all_users where status=1  group by "schema_name"::text,"table" order by 1,2\', \'select distinct "table"::text from admin.all_users order by 1\') AS final_result("schema_name" text,"parent" text,"setting" text, "student" text, "teacher" text, "user" text) ) a where schema_name=\'' . $id . "'";
            $this->data['user'] = \collect(\DB::select($sql))->first();
            $this->data['school'] = $setting = \DB::table($id . '.setting')->first();
            return view('invoice.show', $this->data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function search() {
        $invoice = request('invoice');
        dd(request()->all());
    }

}
