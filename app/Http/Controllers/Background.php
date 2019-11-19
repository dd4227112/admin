<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class Background extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
       // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tag = 'sms') {
        //
        return $tag == 'sms' ?
                $this->dispatch((new \App\Jobs\PushSMS())) :
                $this->dispatch((new \App\Jobs\PushEmail()));
    }

    public function sendSms() {
        $messages = DB::select('select * from public.all_sms limit 15');
        if (!empty($messages)) {
            foreach ($messages as $sms) {
                define('API_KEY', $sms->api_key);
                define('API_SECRET', $sms->api_secret);

                $karibusms = new \karibusms();
                $karibusms->set_name(strtoupper($sms->schema_name));
                $karibusms->karibuSMSpro = $sms->type;
                $result = (object) json_decode($karibusms->send_sms($sms->phone_number, $sms->body));
                if ($result->success == 1) {
                    DB::update('update ' . $sms->schema_name . '.sms set status=1 WHERE sms_id=' . $sms->sms_id);
                } else {
                    DB::update('update ' . $sms->schema_name . '.sms set status=0 WHERE sms_id=' . $sms->sms_id);
                }
            }
        }
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
        //
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

    public function updateInvoice() {
        exit;
        $invoices = DB::select('select * from api.invoices where sync=1 and amount >0 and payment_integrated=1 order by random() limit 200');
        if (count($invoices) > 0) {
            foreach ($invoices as $invoice) {
                $token = $this->getToken($invoice);
                if (strlen($token) > 4) {
                    $fields = array(
                        "reference" => trim($invoice->reference),
                        "student_name" => $invoice->student_name,
                        "student_id" => $invoice->student_id,
                        "amount" => $invoice->amount,
                        "type" => $this->getFeeNames($invoice->id, $invoice->schema_name),
                        "code" => "10",
                        "callback_url" => "http://51.77.212.234:8081/api/init",
                        "token" => $token
                    );
                    // $push_status = $invoice->status == 2 ? 'invoice_update' : 'invoice_submission';
                    $push_status = 'invoice_update';
                    if ($invoice->schema_name == 'beta_testing') {
                        //testing invoice
                        $setting = DB::table('beta_testing.setting')->first();

                        $url = 'https://wip.mpayafrica.com/v2/' . $push_status;
                    } else {
                        //live invoice
                        $setting = DB::table($invoice->schema_name . '.setting')->first();
                        $url = 'https://api.mpayafrica.co.tz/v2/' . $push_status;
                    }
                    $curl = $this->curlServer($fields, $url);
                    $result = json_decode($curl);
                    if (($result->status == 1 && strtolower($result->description) == 'success') || $result->description == 'Duplicate Invoice Number') {
//update invoice no
                        DB::table($invoice->schema_name . '.invoices')
                                ->where('reference', $invoice->reference)->update(['sync' => 1, 'return_message' => $curl, 'push_status' => $push_status]);
                    }
                    DB::table('api.requests')->insert(['return' => $curl, 'content' => json_encode($fields)]);
                }
            }
        }
    }

    public function getToken($invoice) {
        if ($invoice->schema_name == 'beta_testing') {
            //testing invoice
            //  $setting = DB::table('beta_testing.setting')->first();
            $url = 'https://wip.mpayafrica.com/v2/auth';
            $credentials = DB::table('admin.all_bank_accounts_integrations')->where('invoice_prefix', $invoice->prefix)->first();
            if (count($credentials) == 1) {
                $user = trim($credentials->sandbox_api_username);
                $pass = trim($credentials->sandbox_api_password);
            } else {
                $user = '';
                $pass = '';
            }
        } else {
            //live invoice
            // $setting = DB::table($invoice->schema_name . '.setting')->first();
            $url = 'https://api.mpayafrica.co.tz/v2/auth';
            $credentials = DB::table($invoice->schema_name . '.bank_accounts_integrations')->where('invoice_prefix', $invoice->prefix)->first();
            if (count($credentials) == 1) {
                $user = trim($credentials->api_username);
                $pass = trim($credentials->api_password);
            } else {
                $user = '';
                $pass = '';
            }
        }
        $request = $this->curlServer([
            'username' => $user,
            'password' => $pass
                ], $url);
        $obj = json_decode($request);
        //DB::table('api.requests')->insert(['return' => json_encode($obj), 'content' => json_encode($request)]);
        if (isset($obj) && is_object($obj) && isset($obj->status) && $obj->status == 1) {
            return $obj->token;
        }
    }

    function getFeeNames($invoice_id, $schema_name) {
        $fees = DB::table($schema_name . '.invoices')
                ->where('invoices.id', $invoice_id)
                ->join($schema_name . '.invoices_fees_installments', 'invoices_fees_installments.invoice_id', 'invoices.id')
                ->join($schema_name . '.fees_installments', 'fees_installments.id', 'invoices_fees_installments.fees_installment_id')
                ->join($schema_name . '.fees', 'fees.id', 'fees_installments.fee_id')
                ->get();
        $names = array();
        if (count($fees) > 0) {
            foreach ($fees as $fee) {

                array_push($names, $fee->name);
            }
        }
        $uq_names = array_unique($names);
        return implode(',', $uq_names);
    }

}
