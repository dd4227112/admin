<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Invoices;
use PDF;
use Auth;

class PaymentController extends Controller {

    /**
     *
     * @var Integer 
     */
    public $transaction_id;

    /**
     *
     * @var Integer 
     */
    public $payment_id;

    /**
     *
     * @var Mixed 
     * @uses show the reference number to accept payment,
     *       the reference is used in communicaiton with bank to 
     *       identify who pays and is unique      
     */
    private $reference;

    /**
     *
     * @var Mixed 
     */
    private $HEADER = array(
        'application/x-www-form-urlencoded'
    );

    /**
     *
     * @var Mixed parameters received in api 
     */
    private $api_param;

    /**
     *
     * @var Mixed  
     */
    private $api_info;

    /**
     * @var Client ID
     */
    public $client_id;

    /**
     * @access public : Load payment modal and initialize transaction ID
     *  
     */
    public $usertype;
    public $live_username = '109M17SA01DINET';
    public $live_password = 'LuHa6bAjKV5g5vyaRaRZJy*x5@%!yBBBTVy';
    public $live_url = 'https://api.mpayafrica.co.tz/v2/auth';
    private $selcom_url = '';
    public $selcom_api_key;
    public $selcom_api_end_point;
    public $selcom_api_secret;
    public $till = "TILL60196151";
    private $base_url;
    private $selcom_vendor_id = '';

// Successful response
    const SUCCESS = 200; //
//Invalid Token
    const INVALID_TOKEN = 201;
//Invalid checksum
    const INVALID_CHECKSUM = 202;
//Payment reference number already paid – During verify method (applies for FIXED amount type)
    const INVOICE_PAID = 203;
//Invalid payment reference number
    const INVALID_INVOICE = 204;
//Payment reference number has expired
    const INVOICE_EXPIRED = 205;
//Duplicate entry : Return the receipt number of the transaction.
    const DUPLICATE_PAYMENT = 206;
//Transaction reference number already paid – During post method
    const TRANSACTION_EXISTS = 207;

    public $server_ip = 'http://75.119.140.177:8081';

    public function __construct() {
      //  parent::__construct();
//$this->lang->load('invoice');
        $this->reference = strlen(request('paymentReference')) > 3 ? request('paymentReference') : request('reference');
//Set your appropirate timezone
        date_default_timezone_set('Africa/Dar_es_Salaam');
        $production = 1;
        $this->selcom_api_end_point = '/checkout/create-order';
        if ($production == 1) {
            $this->selcom_api_key = 'SHULESOFT-9Ylj0rPnRhVUkUSk';
            $this->selcom_api_secret = '78452562-9D21-4K13-aT8G-a78c1b158745';
            $this->base_url = 'https://apigw.selcommobile.com/v1';
            $this->till = "TILL60196151";
        } else {
            $this->selcom_api_key = 'SHULESOFT-8Ylj0rPnRhVUkUSa';
            $this->selcom_api_secret = '77442562-9H21-4K13-aT85-a78c1b158745';
            $this->base_url = 'https://apigwtest.selcommobile.com/v1';
        }

        $this->save_api_request();
    }

    public function remoteAccess() {
        $action = request('action');

        $order = array("order_id" => request('order_id'), "amount" => request('amount'),
            'buyer_name' => request('buyer_name'), 'buyer_phone' => request('buyer_phone'));


// if ($action == 'createOrder') {
        $this->selcom_api_end_point = '/checkout/create-order';
        return $this->createOrder($order);
//        } else if ($action == 'cancel') {
//            return $this->createOrder($order);
//        }
//   return false;
    }

    public function cancelOrder($order_id) {
        $this->selcom_api_end_point = '/v1/checkout/cancel-order?id=' . $order_id;
        return $this->buildRequest(array(), 'CANCEL');
    }

    private function buildRequest($req, $action = null) {
        $this->selcom_url = $this->base_url . $this->selcom_api_end_point;
        $timestamp = date('c'); //2019-02-26T09:30:46+03:00
        $signed_fields = implode(',', array_keys($req));
        $digest = $this->computeSignature($req, $signed_fields, $timestamp, $this->selcom_api_secret);
        $action == null ? $this->createBooking($req) : '';
        return (object) $this->sendJSONPost($this->selcom_url, json_encode($req), $digest, $signed_fields);
    }

    function createOrder($request) {
        $names = explode(' ', $request['buyer_name']);
        $req = array_merge($request, array("vendor" => $this->till,
            'buyer_email' => 'support@shulesoft.com',
            'currency' => 'TZS', 'payment_methods' => 'ALL',
            'redirect_url' => base64_encode(url('/') . '/media/livestream'),
            'webhook' => base64_encode($this->server_ip . '/api/webhook'),
            'billing.phone' => $request['buyer_phone'],
            'billing.firstname' => $names[0], 'billing.lastname' => count($names) > 1 ? $names[1] : $names[0], 'billing.address_1' => '2nd Floor, 576 block. Bagamoyo Road', 'billing.city' => 'Dar es salaam', 'billing.state_or_region' => 'Dar es salaam', 'billing.postcode_or_pobox' => '32282', 'billing.country' => 'TZ', 'no_of_items' => '1'));
        $return = $this->buildRequest($req);
        if (isset($return->result) && $return->result == 'SUCCESS') {
            $data = (object) $return->data[0];
//$schema = str_replace('.', null, set_schema_name());
//$schema_name = in_array($schema, ['jifunze', 'beta_testing']) ? 'admin' : $schema;
            DB::table('admin.invoices')->where('order_id', $req['order_id'])->update([
                'reference' => $return->reference, 'token' => $data->payment_token,
                'gateway_buyer_uuid' => $data->gateway_buyer_uuid, 'qr' => $data->qr,
                'payment_gateway_url' => $data->payment_gateway_url, 'updated_at' => 'now()'
            ]);
            return json_encode($data);
        } else {
            die(json_encode(['error' => 500, 'message' => 'We are facing a problem to create your reference, please try again later', 'data' => $request, 'result' => $return]));
        }
    }

    public function createBooking($request) {
        $req = (object) $request;
        $schema = str_replace('.', null, set_schema_name());
        $user = DB::table('users')->first();
        if (in_array($schema, ['jifunze', 'beta_testing'])) {
            $schema_name = 'admin';
        } else {
            $schema_name = $schema;
        }
        if ((int) request('client_id') > 0 || (int) request('source') > 0) {
            $client = (int) request('client_id') > 0 ? request('client_id') : 0;
            $client_id = (int) $client > 0 ? $client : request('source');

            $invoice = DB::table('admin.invoices')->where('client_id', $client_id)->where('order_id', $req->order_id)->first();
            if (!empty($invoice)) {
                return DB::table('admin.invoices')->where('client_id', $client_id)->where('order_id', $req->order_id)->update([
                            'amount' => $req->amount,
                ]);
            } else {
                return DB::table('admin.invoices')->insert([
                            'order_id' => $req->order_id,
                            'amount' => $req->amount,
                            'user_id' => 2,
                            'sid' => (int) request('client_id') > 0 ? (int) request('client_id') : $user->sid,
                            "client_id" => request('source') == 'karibusms' || (int) request('source') == 0 ? 79 : request('source'),
                            'source' => strlen(request('source')) > 2 ? 'karibusms' : '',
                            'status' => 0,
                            'schema_name' => $schema,
                            'methods' => 'selcom'
                ]);
            }
        }
    }

    function sendJSONPost($url, $json, $digest, $signed_fields) {
        $authorization = base64_encode($this->selcom_api_key);
        $timestamp = date('c');
        $headers = array(
            "Content-type: application/json;charset=\"utf-8\"", "Accept: application/json", "Cache-Control: no-cache",
            "Authorization: SELCOM $authorization",
            "Digest-Method: HS256",
            "Digest: $digest",
            "Timestamp: $timestamp",
            "Signed-Fields: $signed_fields",
        );

        $isPost = true;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
// if ($isPost) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
//}
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $result = curl_exec($ch);

        curl_close($ch);
        $resp = json_decode($result, true);
        return $resp;
    }

    function computeSignature($parameters, $signed_fields, $request_timestamp, $api_secret) {
        $fields_order = explode(',', $signed_fields);
        $sign_data = "timestamp=$request_timestamp";
        foreach ($fields_order as $key) {
            $sign_data .= "&$key=" . $parameters[$key];
        }

//RS256 Signature Method
#$private_key_pem = openssl_get_privatekey(file_get_contents("path_to_private_key_file"));
#openssl_sign($sign_data, $signature, $private_key_pem, OPENSSL_ALGO_SHA256);
#return base64_encode($signature);
//HS256 Signature Method
        return base64_encode(hash_hmac('sha256', $sign_data, $api_secret, true));
    }

    public function shulesoftAcademyPayments($order_id, $payment_status, $reference, $result, $transid) {
        $web = DB::table('admin.invoices')->where('order_id', $order_id)->first();
        if (!empty($web)) {
            if (strtoupper($result) == 'SUCCESS' && strtoupper($payment_status) == 'COMPLETED') {
                DB::table('admin.invoices')->where('order_id', $order_id)->update(['status' => 1]);
//this user already paid, save in payments and grant access
                $payment_array = array(
                    'amount' => $web->amount,
                    "client_id" => $web->source == 'karibusms' ? 97 : 197,
                    "invoice_id" => $web->id,
                    "payment_type_id" => 3,
                    'channel' => request('channel'),
                    'phone' => request('phone'),
                    "date" => 'now()',
                    "cheque_number" => $reference,
                    "transaction_id" => $transid,
                    'bank_account_id' => 1,
                    'token' => $web->token,
                    'method' => 'selcom',
                    'reconciled' => 0
                );
                DB::table("admin.payments")->insert($payment_array);
//                $package = DB::table('admin.livestudy_packages')->where('amount', $web->amount)->first();
//                if (empty($package)) {
////When someone try to enter amount different from the one we have specified
//                    $package = DB::table('admin.livestudy_packages')->first();
//                }
//                $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $package->days . ' day'));
//                DB::table('admin.livestudy_payments')->insert([
//                    'sid' => $web->sid,
//                    'payment_id' => $payment_id,
//                    'livestudy_package_id' => $package->id,
//                    'start_date' => 'now()',
//                    'end_date' => $end_date
//                ]);
                if ($web->source == 'karibusms') {
                    $sms_provided = ceil($web->amount / 20);
                    $array = [
                        "currency" => 'TZS', "amount" => $web->amount, "transaction_code" => $transid, "cost_per_sms" => 20, "method" => 'selcom', "client_id" => $web->sid, "confirmed" => 1, "staff_id_approved" => 1, "approved" => 1, "payment_per_sms" => 1, "sms_provided" => $sms_provided];


                    $check = DB::connection('karibusms')->table('payment')->where('invoice', $web->token)->first();
                    if (!empty($check)) {
                        DB::connection('karibusms')->table('payment')->where('invoice', $web->token)->update($array);
                    } else {
                        DB::connection('karibusms')->table('payment')->insert($array);
                    }
                }
                die($this->saveReturn(['data' => request()->all(), 'resultcode' => '000', 'result' => 'SUCCESS', 'message' => 'Payment Accepted Successfully']));
            } else {
                die($this->saveReturn(['data' => request()->all(), 'resultcode' => $payment_status, 'result' => $result, 'message' => 'unknown return format']));
            }
        } else {
            die($this->saveReturn(['data' => request()->all(), 'resultcode' => '000', 'result' => 'FAIL', 'message' => 'Order ID does not exists in our end']));
        }
    }

    public function saveReturn($object) {
        $this->save_api_request($object);
        return die(json_encode($object));
    }

    /**
     * {"result":"SUCCESS","order_id":"1586532572","transid":"901714691146","reference":"0328894880","channel":"AIRTELMONEY","amount":"2000","phone":"255689353642","payment_status":"COMPLETED"}
     */
    public function selcomWebhook() {
//accept payment, store in payment table
//update booking table, set status=3
        $transid = request('transid');
        $order_id = request('order_id');
        $reference = request('reference');
        $result = request('result');
        $payment_status = request('payment_status');

        if (strlen($order_id) < 2) {
            $object = ['data' => request()->all(), 'resultcode' => '000', 'result' => 'FAIL', 'message' => 'Order ID is empty'];
            $this->save_api_request($object);
            die(json_encode($object));
        }
        if (preg_match('/TZ/', strtoupper(request('reference')))) {
            return $this->clearLiveStudyPayments();
        } else {
            return $this->shulesoftAcademyPayments($order_id, $payment_status, $reference, $result, $transid);
        }
    }

    public function schema() {
        
    }

    /**
     * @uses Initial loading of appliation 
     */
    public function index() {

        $invoice_id = request()->segment(3);
        $invoice = \collect(DB::select('select * from invoices where id=' . $invoice_id . ''))->first();
        if (!empty($invoice)) {
            $this->data['invoice_number'] = $invoice->reference;
            $this->data['invoice_id'] = $invoice_id;
         // $invoice_fee = \collect(DB::select('select 
        //  coalesce(coalesce(sum(a.total_amount),0)-coalesce(sum(a.discount_amount),0),0) as amount, coalesce(coalesce(sum(a.total_payment_invoice_fee_amount),0)+coalesce(sum(a.total_advance_invoice_fee_amount)),0) as paid_amount, sum(a.balance) as balance, a.invoice_id as id,a.student_id, c.reference, b.name as student_name from invoice_balances a join student b on a.student_id=b.student_id join invoices c on c.id=a.invoice_id  join fees d on d.id=a.fee_id where a.invoice_id=' . $invoice_id . ' group by a.invoice_id,b.name ,a.student_id,c.reference'))->first();
        //  $this->data['amount'] = $invoice_fee->balance;

          //  $this->data['fees'] = $this->getFeeNames($invoice_id);
          //  $this->data['charges'] = $this->data['siteinfos']->transaction_charges_to_parents == 1 ? 1000 : 0;
            $this->data['invoices'] = \App\Models\Invoice::find($invoice_id);
              $page = request()->segment(4);
            //  $this->data['amount'] = $invoice_fee->balance;

            if (preg_match('/nmb/', $page)) {
              //  $this->data["subview"] = "invoice/payment/nmb";
                return view('account.invoice.payment.nmb', $this->data);
            } else if (preg_match('/crdb/', $page)) {
                return view('account.invoice.payment.mobile', $this->data);
            } else if (preg_match('/mobile/', $page)) {
                return view('account.invoice.payment.mobile', $this->data);
            } else if (preg_match('/checkout/', $page)) {
                $this->data['user'] = \App\Models\User::find(Auth::user()->id);
                return view('account.invoice.payment.card', $this->data);
                //$this->data["subview"] = "account.invoice.payment.mobile";
            } else {
                $this->data["subview"] = "invoice/payment/request";
            }
        } else {
            echo 'Sorry, this invoice does not exists';
        }
    }

    public function payment_list() {

        $data['request'] = $this->db->query("SELECT p.invoice,p.reg_date,p.summary,p.amount,p.name,p.payment_ready,p.is_pay_confirmed, b.book_date,b.currency FROM  " . set_schema_name() . "payment_requests p JOIN " . set_schema_name() . "booking b ON p.booking_id=b.booking_id WHERE p.client_id ='" . $this->client_id . "'AND  p.is_pay_confirmed='0' AND p.invoice !=''");
        $data['count'] = $data['request']->num_rows();
        $this->load_view('payment_list', $data);
    }

    public function complete() {
        $data['invoice'] = request('invoice');
        $name = request('name');
        $data['bname'] = empty($name) ? "BRELA" : $name;
// select from a table
        $this->load->view('confirm', $data);
    }

    public function requestIntegration() {
        if ($_POST) {
            $client = DB::table('admin.clients')->where('username', str_replace('.', NULL, set_schema_name()))->first();
            $object = array(
                'client_id' => $client->id,
                'bank_id' => request('bank_id'),
                'user_id' => session('id'),
                "table" => session('table'),
                'schema_name' => str_replace('.', NULL, set_schema_name()),
                'students' => request('students'),
                'phone' => request('phone'),
                'email' => request('email'),
                'message' => request('message')
            );
            $insert = DB::table('admin.new_integration_requests')->insert($object);
            $bank = DB::table('bank_accounts')->where('id', request('bank_id'))->first();
            $customer = DB::table('users')->where('id', session('id'))->where('table', session('table'))->first();
            $details = 'Hi <br/>'
                    . 'School Name ' . str_replace('.', NULL, set_schema_name()) . ' Request Integration <br/>'
                    . 'Bank Name: ' . $bank->name . '<br/>'
                    . 'Bank Account: ' . $bank->number . '<br/>'
                    . 'Customer Message: ' . request('message') . '<br/>'
                    . 'Total Students: ' . request('students') . '<br/>'
                    . 'Customer Name: ' . $customer->name . ' , Title: ' . $customer->usertype . '<br/>'
                    . 'Bank Contact Details<br/>'
                    . 'Email: ' . request('email') . '<br/>'
                    . 'Phone: ' . request('phone') . '<br/>'
                    . '<br/>';
            $subject = str_replace('.', NULL, set_schema_name()) . ' Request for payment integration';
            $obj = array('user_id' => $customer->id, 'table' => $customer->table, 'body' => $details, 'subject' => $subject, 'email' => 'ephraim@shulesoft.com');
            DB::table('public.email')->insert($obj);
            return redirect('setting/index#payment_intergration_settings')->with('success', 'Your Request has been submitted, you will be notified once your bank accept your request through us');
        }
    }

    public function apply() {
        /*
         * this method should now receive an invoice only, then, from that, we 
         * can derive any other parameter we need since its a unique values
         */

        $step = request()->segment(4);
        $this->data['type'] = $type = request()->segment(3);
        $refer_bank_id = strtolower($this->data['type']) == 'crdb' ? 8 : 22;
        $this->data['partner'] = DB::table('admin.partners')->where('refer_bank_id', $refer_bank_id)->first();
        switch ($step) {
            case 1:
                $page = 'index';
                $this->data['api'] = DB::table('api.entity')->where('username', $this->data['type'])->first();
                break;

            case 2:
                $page = 'steptwo';
                $this->data['total_students'] = DB::table('student')->where('status', 1)->count();
                $this->data['banks'] = DB::table('bank_accounts')->where('refer_bank_id', $refer_bank_id)->get();
                $this->data['bank_documents'] = DB::SELECT('select b.id,a.name, a.path from admin.integration_bank_documents b join admin.company_files a '
                                . ' on a.id=b.company_file_id where b.refer_bank_id=' . $refer_bank_id);

                break;
            case 3:

                $client = DB::table('admin.clients')->where('username', str_replace('.', NULL, set_schema_name()))->first();
                $this->data['bank_id'] = $bank_id = request('bank_id');
                $this->data['students'] = $students = request('students');

                $integration = DB::table('bank_accounts_integrations')->where('bank_account_id', $bank_id)->first();
                if (!$integration && (int) $bank_id > 0) {
                    $bank_accounts_integration_id = DB::table('bank_accounts_integrations')->insertGetId(['bank_account_id' => $bank_id]);
                } else {
                    $bank_accounts_integration_id = $integration->id;
                }

                $object = array('client_id' => $client->id,
                    'refer_bank_id' => $refer_bank_id,
                    'bank_account_id' => $bank_id,
                    'user_id' => session('id'),
                    "table" => session('table'),
                    'bank_accounts_integration_id' => $bank_accounts_integration_id,
                    'schema_name' => str_replace('.', NULL, set_schema_name())
                );
                $int = DB::table('admin.integration_requests')->where('bank_accounts_integration_id', $bank_accounts_integration_id)->where('client_id', $client->id)->first();
                $integration_request_id = '';

                if (empty($int)) {
                    $integration_request_id = DB::table('admin.integration_requests')->insertGetId($object);
                    $this->data['invoice_id'] = $this->createInvoice($client->id, $students, $refer_bank_id, $integration_request_id);
                } else {
                    $integration_request_id = $int->id;
                    $invoice = DB::table('admin.integration_requests_invoices')->where('integration_request_id', $int->id)->first();
                    $this->data['invoice_id'] = !empty($invoice) ? $invoice->invoice_id : $this->createInvoice($client->id, $students, $refer_bank_id, $integration_request_id);
                }
                $invoice_amount = DB::table('admin.invoice_fees')->where('invoice_id', $this->data['invoice_id'])->sum('amount');
                $this->data['invoice_amount'] = $invoice_amount;
                $this->data['reference'] = DB::table('admin.invoices')->where('id', $this->data['invoice_id'])->first()->reference;
                $this->data['request_id'] = $integration_request_id;

                //attach any file to this requests

                $files = request('bank_document');
                if (!empty($files)) {
                    foreach ($files as $key => $file) {
                        $path = \Storage::disk('s3')->put('company/contracts', $file);
                        $url = \Storage::disk('s3')->url($path);

                        $company_file_id = DB::table('admin.company_files')->insertGetId([
                            'name' => $file->getClientOriginalName(),
                            'extension' => $file->getClientOriginalExtension(),
                            'user_id' => 3, //we force to assume CEO upload it
                            'size' => $file->getSize(),
                            'caption' => $file->getRealPath(),
                            'path' => $url
                        ]);
                        DB::table('admin.integration_requests_documents')->insert([
                            'integration_request_id' => $integration_request_id,
                            'integration_bank_document_id' => $key,
                            'company_file_id' => $company_file_id
                        ]);
                    }
                }
//                $message = 'Dear ' . $client->name . ' 
//We are glad to inform you that your application was successfully submitted for 
//' . strtoupper($this->data['type']) . ' Electronic Payment Integration. Your application is on verification stage.
//We shall let you know once we have done with verification, then you can proceed with payment integration services. ';
//                $this->send_sms($client->phone_number, $message);
//                $this->send_email($client->email, 'E-Payment Application Status', $message);
                $page = $this->data['partner'] && (int) $this->data['partner']->price > 0 ? 'stepthree' : 'stepfour';
                break;
            case 4:
                $invoice_id = request('invoice_id');
                $invoice_payment = DB::table('admin.payments')->where('invoice_id', $invoice_id)->sum('amount');
                $invoice_amount = DB::table('admin.invoice_fees')->where('invoice_id', $invoice_id)->sum('amount');
                $this->data['invoice_amount'] = $invoice_amount;
                $this->data['reference'] = DB::table('admin.invoices')->where('id', $invoice_id)->first()->reference;

                if ((float) $invoice_payment < $invoice_amount) {
                    $bank_id = request('bank_id');
                    $students = request('students');
                    return redirect('paymentController/apply/crdb/3?bank_id=' . $bank_id . '&students=' . $students)->with('warning', 'Sorry, you need to make payments first to join this service');
                }
                $page = 'stepfour';

                break;
            default:
                $page = 'index';
                break;
        }
        return view('payment.apply.' . $page, $this->data);
    }

    public function createInstructionForm() {

//return view('payment.apply.standing_order', $this->data);
//        $file_name = set_schema_name() . 'crdb_instruction.docx';
//        return response()->download('storage/app/' . $file_name, $file_name, array('Content-Type: application/vnd.ms-word'));
//        return NULL;

        $data = [];

        $request_id = request()->segment(4);
        $invoice_id = request()->segment(3);
        $this->data['invoice_amount'] = DB::table('admin.invoice_fees')->where('invoice_id', $invoice_id)->sum('amount');
        $this->data['request'] = DB::table('admin.integration_requests_invoices')->where('integration_request_id', $request_id)->first();
        $bank_details = DB::table('admin.integration_requests')->where('id', $this->data['request']->integration_request_id)->first();

        $this->data['bank'] = \App\Model\BankAccountIntegration::find($bank_details->bank_accounts_integration_id);

        $pdf = PDF::loadView('payment.apply.standing_order', $this->data);

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function submitInstructionForm() {
        $file = request()->file('bank_instruction');
        $path = \Storage::disk('s3')->put('company/contracts', $file);
        $url = \Storage::disk('s3')->url($path);
        $files_data = [
            'name' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'user_id' => 3, //we force to assume CEO upload it
            'size' => $file->getSize(),
            'caption' => $file->getRealPath(),
            'path' => $url
        ];
        $company_file_id = DB::table('admin.company_files')->insertGetId($files_data);
        $invoice = DB::table('admin.invoices')->where('id', request('invoice_id'))->first();
        $amount = DB::table('admin.invoice_fees')->where('invoice_id', $invoice->id)->sum('amount');
        $data = array(
            'company_file_id' => $company_file_id,
            'type' => 'Yearly',
            'created_by' => session('id'),
            'created_by_table' => session('table'),
            'approved_by' => 3,
            'client_id' => $invoice->client_id,
            'amount' => $amount,
            'payment_date' => date('Y-m-d', strtotime(request('pay'))),
            'refer_bank_id' => request('refer_bank_id'),
            'bank_account_id' => request('bank_id'),
            'contract_type_id' => 6,
            'note' => 'crdb standing order form'
        );
        DB::table('admin.standing_orders')->insert($data);
        return redirect(url('setting/index#payment_intergration_settings'))->with('success', 'success');
    }

    public function createInvoice($client_id, $total_students, $refer_bank_id, $integration_request_id) {
        $partner = DB::table('admin.partners')->where('refer_bank_id', $refer_bank_id)->first();
        if ($partner && (int) $partner->price > 0) {
            $reference = time() . $client_id;
            $order_id = time();
            $account_year = DB::table('admin.account_years')->where('name', date('Y'))->first();
            $invoice_id = DB::table('admin.invoices')->insertGetId(['reference' => $reference, 'client_id' => $client_id, 'date' => 'now()', 'year' => date('Y'),
                'user_id' => 3, // put this default to CEO, wirerd
                'account_year_id' => !empty($account_year) ? $account_year->id : DB::table('admin.account_years')->insertGetId([
                    'name' => date('Y'), 'start_date' => date('Y') . '-01-01', 'end_date' => date('Y') . '-12-31'
                ]),
                'order_id' => $order_id, 'sid' => $client_id, 'note' => 'integration',
                'due_date' => date('Y-m-d', strtotime('+ 30 days'))]);

//            $months_remains = 12 - (int) date('m') + 1;
//            $price_per_student = $months_remains * $partner->price / 12;
            $amount = $total_price = $total_students * $partner->price;

            DB::table('admin.integration_requests_invoices')->insert(['integration_request_id' => $integration_request_id, 'invoice_id' => $invoice_id]);

            DB::table('admin.invoice_fees')->insert(['invoice_id' => $invoice_id, 'amount' => $amount, 'project_id' => 1,
                'item_name' => 'ShuleSoft Service Fee For ' . $total_students . ' Students ',
                'quantity' => $total_students, 'unit_price' => $partner->price]);

            $order = array("order_id" => $order_id, "amount" => $total_price,
                'buyer_name' => $this->data['siteinfos']->sname, 'buyer_phone' => '255655406004', 'end_point' => '/checkout/create-order',
                'action' => 'createOrder', 'client_id' => $client_id, 'source' => str_replace('.', NULL, set_schema_name()));

            $this->curlPrivate($order);
            //$payment->createOrder($order);
            //send this invoice to user email and to CRDB email
            //add loaders

            return $invoice_id;
        }
    }

    private function crdbInitRequest() {
        $checksum = $this->request_value('checksum');
        $valid = sha1($this->request_value('token') . md5($this->request_value('paymentReference')));

        if ($checksum == $valid) {
            return request('transactionRef') == null ? 1 : 2;
        } else {
            $data = array(
                'status' => 202,
                "statusDesc" => "Fail",
                "data" => array("Message" => "Invalid checksum")
            );
            die(json_encode($data));
        }
    }

    /**
     * 
     * @return int : Request position number
     */
    private function init_api_request() {

        $api_key = request("api_key");
        $api_secret = request("api_secret");
// first save all information received via API request
        $this->save_api_request();
//check keys if they exist and get user information. Compare if its NMB request or other requests

        if (strlen(request('checksum')) > 4) {
            //NMB request
            return $this->crdbInitRequest();
        } else if (strlen(request('api_key')) > 2) {
            //selcom | NBC request
            $this->api_info = \collect(DB::select("select * from api.developer"))->first();
        } else {
            //crdb requests
            $this->api_info = \collect(DB::select("select * from api.developer"))->first();
        }
        if (empty($this->api_info)) {
            $data = array(
                'status' => 3,
                'description' => 'Invalid api key or secret',
                'reference' => $this->reference
            );
            die(json_encode($data));
        } else {

            return request('receipt') == null ? 1 : 2;
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
        if (!empty($fees)) {
            foreach ($fees as $fee) {

                array_push($names, $fee->name);
            }
        }
        $uq_names = array_unique($names);
        return implode(', ', $uq_names);
    }

    public function uploadPayments($data_value_object, $id = null, $schema = null) {

        $value_array = (array) \GuzzleHttp\json_decode($data_value_object);

        $call_array = new \App\Http\Controllers\Student();
        $value = $call_array->modify_keys_to_upper_and_underscore($value_array);

        $status = '';
        $student = \DB::table($schema . '.student')->where(DB::raw('lower(roll)'), strtolower(trim($value['roll'])))->first();
        $transaction_id = isset($value['transaction_id']) ?
                $value['transaction_id'] : time();

        if (!empty($student)) {
            $class_level = DB::table($schema . '.classes')->where('classesID', $student->classesID)->first();
            $year = DB::table($schema . '.academic_year')->where('name', $value['academic_year'])->where('class_level_id', $class_level->classlevel_id)->first();

            $account_number = isset($value['account_number']) ?
                    $value['account_number'] : null;
            $bank_records = DB::table($schema . '.bank_accounts')->where('number', trim($account_number))->first();
            $payable_amount = $value['amount'];
            $pdata = DB::table($schema . '.payments')->where(DB::raw('lower(transaction_id)'), strtolower(trim($transaction_id)))->first();
            if (!empty($pdata)) {
                $status .= '<p class = "alert alert-danger">This transaction ID "' . $transaction_id . '" already exists. Information skipped</p>';
            } else if ($payable_amount == 0 || $payable_amount == '') {
                $status .= '<p class = "alert alert-danger">Amount specified "' . $value['amount'] . '" is not valid for this student ' . $student->name . '. Information skipped</p>';
            } else if (empty($bank_records)) {

                $status .= '<p class = "alert alert-danger">The bank with account number "' . $account_number . '" is not yet defined in ShuleSoft. Please define this bank details in account setting. Information skipped</p>';
            } else if (empty($year)) {
                $status .= '<p class = "alert alert-danger">This academic year "' . $value['academic_year'] . '" for this level "' . $class_level->classes . '" does not exists. Please define it in system setting, Information skipped </p>';
            } else {
                $payable_amount = $value['amount'];

                $invoice = \DB::table($schema . '.invoice_balances')->where('student_id', $student->student_id)->where('academic_year_id', $year->id)->where('fee_id', '<>', 3000)->first();
                if (empty($invoice)) {
                    $status .= '<p class = "alert alert-danger">Student with name ' . $student->name . ' has no invoice number</p>';
                } else {
                    $payment_type = \App\Model\PaymentType::where(DB::raw('lower(name)'), 'like', strtolower($value['payment_type']))->first();
                    $payment_type_id = !empty($payment_type) ? $payment_type->id : \App\Model\PaymentType::first()->id;
                    if (isset($value['fee_name'])) {
                        $fee = DB::table('fees')->where(DB::raw('lower(name)'), strtolower(trim($value['fee_name'])))->first();
                    } else {
                        $fee = array();
                    }
                    $date = str_replace('/', '-', $value['date']);
                    $date_value = date('Y-m-d', strtotime($date));
                    $obj = new Invoices();
                    $obj->clearPayments($invoice->invoice_id, $payable_amount, $payment_type_id, $date_value, $transaction_id, $bank_records->id, !empty($fee) ? $fee->id : 0, '', '', $schema);

                    $status .= '<p class = "alert alert-success">Payments of ' . $payable_amount . ' Uploaded for ' . $student->name . '</p>';
                }
            }
        } else {
            if (!empty($value['roll'])) {
                $status .= '<p class = "alert alert-danger">Student with roll ' . $value['roll'] . ' does not exists</p>';
            }
        }
        DB::table($schema . '.tempfiles')->where('id', $id)->update(['processed' => 1, 'status' => $status, 'updated_at' => 'now()']);
    }

    public function receipts() {
        $usertype = $this->session->userdata("usertype");
        $this->data['classlevels'] = $this->classlevel_m->get_order_by_classlevel();
        $class_id = clean_htmlentities(($this->uri->segment(3)));
        $academic_year_id = clean_htmlentities(($this->uri->segment(4)));
        $classesID = $this->data['segment'] = clean_htmlentities(($this->uri->segment(3)));
        $this->data['type'] = $class_id;
        $this->data['classes_id'] = $classesID;
        $this->data['payment'] = array();
        $this->data['classes'] = $this->invoices_m->get_classes();
        if ((int) $class_id > 0 && can_access('view_payment_transaction')) {

            $sections = \App\Model\Section::where('classesID', $class_id)->get(['sectionID'])->toArray();
            $payments = \App\Model\Payment::join('student_archive', 'student_archive.student_id', ' = ', 'payment.student_id')->where('academic_year_id', $academic_year_id)->whereIn('section_id', $sections)->get(['paymentID']);
            $this->data['sections'] = $sections;
            $this->data['receipts'] = \App\Model\Receipt::whereIn('paymentID', $payments)->get();
        } elseif ($academic_year_id != null && ($usertype == 'Parent' || $usertype == 'Student')) {

            $student_id = clean_htmlentities(($this->uri->segment(5)));
            if (empty($student_id)) {
                if (strtolower(session('table')) == 'student') {
                    $this->data['payment'] = \App\Model\Payment::where('student_id', session('id'))->get();
                } else if (strtolower(session('table') == 'parent')) {
                    $students = \App\Model\StudentParent::where('parent_id', session('id'))->get(['student_id'])->toArray();
                    $payments = \App\Model\Payment::whereIn('student_id', $students)->get(['paymentID']);
                    $this->data['receipts'] = \App\Model\Receipt::whereIn('paymentID', $payments)->get();
                }
            } else {

                $payments = \App\Model\Payment::where('student_id', $student_id)->get(['paymentID']);
                $this->data['receipts'] = \App\Model\Receipt::whereIn('paymentID', $payments)->get();
            }
        }

        return view('invoices/payment/receipts', $this->data);
    }

    public function notapproved() {
        $pay_id = clean_htmlentities(($this->uri->segment(3)));
        $this->data['payment'] = array();
        $this->data['classes'] = \App\Model\Classes::all();
        $this->data['prepayments'] = \App\Model\Prepayment::where('approved', 0)->get();
        if ((int) $pay_id > 0 && can_access('view_payment_transaction')) {
            
        }
        return view('payment.notapproved', $this->data);
    }

    public function accept() {
        $pay_id = clean_htmlentities(($this->uri->segment(3)));
        $payment = \App\Model\Prepayment::find($pay_id);
        $obj = (new Invoices())->payment_acceptance_from_bank($payment->paymentamount, $payment->invoiceID, $payment->bank_account_id, $payment->transaction_id, $payment->mobile_transaction_id, $payment->paymenttype, $payment->invoice->academic_year_id, $payment->payer_name, $payment->account_number, $payment->transaction_time, NULL, null, (int) $payment->fee_id, $payment->paymentdate);
        $return = json_decode($obj);
        if ($return->control == 1) {
            $payment->update([
                'approved' => 1,
                'approved_date' => 'now()',
                'approved_user_id' => session('id')
            ]);
        }

        return redirect()->back()->with('success', $return->description);
    }

    public function reject() {
        $pay_id = request('id');
        $reason = request('reason');
        $payment = \App\Model\Prepayment::find($pay_id);

        if (!empty($payment)) {
            $reject_reason = array_merge(strlen($payment->reject_reason) > 5 ? (array) json_decode($payment->reject_reason) : [], ['reason' => $reason, 'date' => date('Y-m-d')]);
            $payment->update([
                'approved' => 3,
                'approved_date' => 'now()',
                'approved_user_id' => session('id'),
                'reject_reason' => json_encode($reject_reason)
            ]);
            $parent = \App\Model\Parents::find($payment->userID);
            $this->send_sms($parent->phone_number, 'Payment Rejection: ' . $reason);
            $this->send_email($parent->email, 'Payment Rejected ', $reason);

            echo 1;
        }
    }

    public function paid_amount() {


        if (can_access('add_feetype')) {
            $this->data['classlevels'] = $this->classlevel_m->get_order_by_classlevel();

            if ($_POST) {

                $classes_id = request("classID");
                $class_level_id = request("class_level_id");
                if ($classes_id != 0 && $class_level_id != 0) {
                    $academic_year = $this->academic_year_m->get_current_year($class_level_id);
                } else {

                    return redirect()->back()->with('warning', 'Please make sure you select both options below');
                }
                $this->data['students'] = DB::select('select a.amount_entered, a."paymentID", b.* from ' . set_schema_name() . ' payment a join ' . set_schema_name() . 'student b ON a."student_id" = b."student_id" where b."classesID" = ' . $classes_id . ' AND b.academic_year_id = ' . $academic_year->id . '');
                $this->data["subview"] = "payment/review_paid_amount";
                $this->load->view('_layout_main', $this->data);
                //return view('fee_installment.register_due_amount',$this->data);
                // return redirect()->back()->with('warning', 'There are currently no students in the selected class');
            } else {

                $this->data['students'] = array();
                //return redirect()->back()->with('warning','There are currently no students in the selected class');

                $this->data["subview"] = "payment/review_paid_amount";
                $this->load->view('_layout_main', $this->data);
            }
        } else {

            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function getBalanceRecord($student_id, $fee_id = null, $invoice_id = null) {
        if ($fee_id == null && $invoice_id == null) {
            $balance = DB::table('invoice_balances')->where('balance', '>', 0)->where('student_id', $student_id)->orderBy('installment_id')->get();
        } else if ($fee_id == null && (int) $invoice_id > 0) {
            $balance = DB::table('invoice_balances')->where('invoice_id', $invoice_id)->where('balance', '>', 0)->where('student_id', $student_id)->orderBy('installment_id')->get();
        } else if ($invoice_id == null && (int) $fee_id > 0) {
            $balance = DB::table('invoice_balances')->where('fee_id', $fee_id)->where('balance', '>', 0)->where('student_id', $student_id)->orderBy('installment_id')->get();
        } else {
            $balance = DB::table('invoice_balances')->where('fee_id', $fee_id)->where('invoice_id', $invoice_id)->where('balance', '>', 0)->where('student_id', $student_id)->orderBy('installment_id')->get();
        }
        return $balance;
    }

    public function clearStudentDueAmount($payment) {
        $due = \App\Model\DueAmount::where('student_id', $payment->student_id);
        $total_due_amount = $due->sum('amount');
        $due_amounts = $due->get();
        $sum_paid = 0;
        foreach ($due_amounts as $value) {
            $sum_paid += $value->dueAmountsPayments()->sum('amount');
        }
        if ($total_due_amount == $sum_paid) {
            $remained_amount = $payment->amount;
        } else {
            //check due amount remains
            $remained_amount = $this->clearDueAmount($due_amounts, $payment);
        }
        return $remained_amount;
    }

    public function clearDueAmount($due_amounts, $payment) {
        $amount = $payment->amount;
        foreach ($due_amounts as $due) {
            if ($amount > 0) {
                if ($amount <= $due->amount) {
                    \App\Model\DueAmountsPayment::create(['payment_id' => $payment->id, 'due_amount_id' => $due->id, 'amount' => $amount]);
                    $amount = 0;
                } else if ($amount > $due->amount) {
                    \App\Model\DueAmountsPayment::create(['payment_id' => $payment->id, 'due_amount_id' => $due->id, 'amount' => $due->amount]);
                    $amount = $amount - $due->amount;
                }
            }
        }
        return $amount;
    }

    public function clearPayment($payment_id, $fee_id = null, $invoice_id = null) {
        $payment = \App\Model\Payment::find($payment_id);
        $amount = $this->clearStudentDueAmount($payment);
        $invoice_info = $this->getBalanceRecord($payment->student_id, $fee_id, $invoice_id);
        foreach ($invoice_info as $invoice) {
            if ($amount > 0) {
                if ($amount <= $invoice->balance) {
                    $this->storeInvoicePayment($payment_id, $invoice->id, $amount);
                    $amount = 0;
                } else if ($amount > $invoice->balance) {
                    $this->storeInvoicePayment($payment_id, $invoice->id, $invoice->balance);
                    $amount = $amount - $invoice->balance;
                }
            }
        }
        if ($amount > 0) {
            \App\Model\AdvancePayment::create(['student_id' => $payment->student_id, 'payment_id' => $payment_id, 'amount' => $amount]);
        }
    }

    public function storeInvoicePayment($payment_id, $invoice_inst_id, $amount) {
        return \App\Model\PaymentsInvoicesFeesInstallment::create(['payment_id' => $payment_id, 'invoices_fees_installment_id' => $invoice_inst_id, 'amount' => $amount]);
    }

    public function optimize_clear_payment() {
        $payment_id = clean_htmlentities(($this->uri->segment(3)));
        //check first if this payment id is not allocated in any payments
        $check = \App\Model\PaymentsInvoicesFeesInstallment::where('payment_id', $payment_id)->sum('amount');
        $adv = \App\Model\AdvancePayment::where('payment_id', $payment_id)->sum('amount');
        $due = \App\Model\DueAmountsPayment::where('payment_id', $payment_id)->sum('amount');
        $sum_distributed = $check + $adv + $due;
        $payment = \App\Model\Payment::find($payment_id);
        if ($payment->amount != $sum_distributed) {
            $this->clearPayment($payment_id);
            return redirect()->back()->with('success', 'Payment cleared successfully');
        }
        return redirect()->back()->with('success', 'Payment already cleared');
    }

    public function request_value($key) {

        if (strlen(request('paymentReference')) > 3 || strlen(request('reference')) > 3 || strlen(request('checksum')) > 3) {
            return request($key);
        } else {
            $param = array_keys(request()->all());
            $ar_param = is_array($param) && count($param) > 0 ? $param[0] : [];
            $request = count($ar_param) > 0 ? (array) json_decode($ar_param) : [];
            return isset($request[$key]) ? $request[$key] : NULL;
        }
    }

    /**
     *
     * @return int : Request position number
     */
    private function initApiRequest() {

        $api_key = $this->request_value("api_key");
        $api_secret = $this->request_value("api_secret");
//check keys if they exist and get user information

        if (strlen($this->request_value('checksum')) > 4 && strlen(request('transactionRef')) == 0) {
            $this->api_info = \App\Model\Api::where('secret', $this->request_value('token'))->first();
            return $this->validateCrdbRequests();
        } else if (strlen(request('reference')) > 2 || strlen(request('transactionRef')) > 2) {
//            $api = DB::table('requests')->where(DB::raw('lower(content)'), 'like', request('token'))->first();
//            if (!empty($api)) {
            $this->api_info = \App\Model\Api::first();
//            } else {
//                $this->api_info = \App\Model\Api::where('key', $api_key)->where('secret', $api_secret)->first();
//            }

            return $this->validateNormalRequests();
        } else {
            $data = array(
                'status' => 201,
                'statusDesc' => 'Invalid request',
                'data' => json_encode($_REQUEST)
            );
            die(json_encode($data));
        }
    }

    public function validateCrdbRequests() {
        if (empty($this->api_info)) {

            $data = array(
                'status' => "201",
                'statusDesc' => 'Invalid token',
                'data' => ['reference' => $this->request_value('paymentReference')]
            );
            die(json_encode($data));
        } else {
            if ((int) request('billId') > 0) {
                //update bilID with valid invoice number
                DB::table('invoices')->where('bil_id', (int) request('billId'))->update(['number' => request('controlNumber')]);
                $data['request'] = 1;
                $data['status'] = 203;
                $data['statusDesc'] = 'success';
                $data['param'] = array(
                    'invoice' => request()->all()
                );
                return json_encode($data);
            }
            return $this->request_value('transactionRef') == null ? 1 : 2;
        }
    }

    public function validateNormalRequests() {
        if (empty($this->api_info)) {

            $data = array(
                'status' => 0,
                'description' => 'Invalid api key or secret',
                'reference' => $this->request_value('reference')
            );
            die(json_encode($data));
        } else {

            return $this->request_value('transactionRef') == null ? 1 : 2;
        }
    }

    public function validateChecksum($reference) {
        $checksum = $this->request_value('checksum');
        $valid = sha1($this->request_value('token') . '' . md5($reference));
        if ($checksum != $valid) {
            $data = array(
                'status' => "202",
                'reference' => $this->request_value('paymentReference'),
                "statusDesc" => "Invalid checksum",
            );
            die(json_encode($data));
        }
    }

    function checkEmptyKeys() {
        if (strlen($this->request_value('checksum')) > 4) {
            $mandatory_fields = array(
                'amount', 'transactionChannel', 'paymentReference', 'transactionRef'
            );
            $this->api_param = request()->all();
            foreach ($mandatory_fields as $key) {
                if (!isset($this->api_param[$key])) {
                    die($key . ' is empty. Mandatory fields includes ' . json_encode($mandatory_fields));
                }
            }
        } else {
            $mandatory_fields = array(
                'receipt', 'amount', 'account_number', 'channel', 'reference'
            );
            $this->api_param = request()->all();
            foreach ($mandatory_fields as $key) {
                if (!isset($this->api_param[$key])) {
                    die($key . ' is empty. Mandatory fields includes ' . json_encode($mandatory_fields));
                }
            }
        }
    }

    public function initParam() {
        $this->checkEmptyKeys();
        $this->reference = $this->request_value('reference') == null ? $this->request_value('paymentReference') : $this->request_value('reference');
        $this->receipt = $this->request_value('receipt') == null ? $this->request_value('transactionRef') : $this->request_value('receipt');
        $this->customer_name = $this->request_value('customer_name') == null ? $this->request_value('payerName') : $this->request_value('customer_name');
        $this->timestamp = $this->request_value('timestamp') == null ? $this->request_value('transactionDate') : $this->request_value('timestamp');
        $this->channel = $this->request_value('channel') == null ? $this->request_value('transactionChannel') : $this->request_value('channel');
    }

    public function save_api_request($object = null) {
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

        $data = ['content' => json_encode(!empty($object) ? $object : request()->all()),
            'remote_ip' => $this->get_remote_ip(),
            'header' => 'REMOTE_ADDR = ' . request('REMOTE_ADDR') . ' REMOTE_PORT = ' . request('REMOTE_PORT'),
            'remote_hostname' => strlen($ip) > 4 ? gethostbyaddr($ip) : ''
        ];
        return DB::table('api.requests')->insert($data);
    }

    private function get_remote_ip() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        }
        return $ip;
    }

    /**
     * @return JSON OBJECT
     * 
     */
    private function firstRequest() {

        $invoice_details = \collect(DB::select('select * from admin.all_invoices where upper(reference) = \'' . strtoupper($this->reference) . "'"))->first();

        if (!empty($invoice_details)) {
//this invoice exist, so lets return it to a client with amount to process
            $invoice_balance = DB::table($invoice_details->schema_name . '.invoice_balances')->where('invoice_id', $invoice_details->id)->sum('balance');
            $data['request'] = 1;

// this invoice is not yet being paid
            $fees = DB::table($invoice_details->schema_name . '.invoices')
                    ->where('invoices.id', $invoice_details->id)
                    ->join($invoice_details->schema_name . '.invoices_fees_installments', 'invoices_fees_installments.invoice_id', 'invoices.id')
                    ->join($invoice_details->schema_name . '.fees_installments', 'fees_installments.id', 'invoices_fees_installments.fees_installment_id')
                    ->join($invoice_details->schema_name . '.fees', 'fees.id', 'fees_installments.fee_id')
                    ->get();
            $names = array();
            if (!empty($fees)) {
                foreach ($fees as $fee) {

                    array_push($names, $fee->name);
                }
            }
            $uq_names = array_unique($names);
            /**
             * FIXED or FLEXIBLE or FULL
              Default = FIXED.
              FIXED – Only the exact amount
              FLEXIBLE – Less or exact amount
              FULL – More or exact amount
             */
            $student = DB::table($invoice_details->schema_name . '.student')->where('student_id', $invoice_details->student_id)->first();
            $payment_type = DB::table($invoice_details->schema_name . '.bank_accounts_integrations')->where('invoice_prefix', $invoice_details->prefix)->first();
            if (strlen(request('paymentReference')) > 3) {
                $data = array(
                    "status" => "200",
                    "statusDesc" => "success",
                    //'callback_url' => $this->server_ip . "/api/init",
                    "data" => array(
                        "payerName" => $student->name,
                        "amount" => $invoice_balance,
                        "amountType" => "FLEXIBLE",
                        "currency" => "TZS",
                        "paymentReference" => $this->reference,
                        "paymentType" => !empty($payment_type) ? $payment_type->payment_type : '10',
                        "paymentDesc" => implode(', ', $uq_names),
                        "payerID" => "$invoice_details->student_id"));
            } else {
                $data = array(
                    'status' => 1,
                    'reference' => request('reference'),
                    'amount' => $invoice_balance,
                    'currency' => 'TZS',
                    'account' => '41515111',
                    'student_name' => $student->name,
                    'student_id' => $invoice_details->student_id,
                    'type' => implode(', ', $uq_names),
                    'code' => "10",
                    "school_code" => "112",
                    'callback_url' => $this->server_ip . "/api/init"
                );
            }
        } else {
//check if this invoice exists in non-recurring fee
            $data = array(
                'status' => 204,
                'reference' => $this->reference,
                'description' => 'Unknown invoice number'
            );
        }
        echo json_encode($data);
    }

    public function clearLiveStudyPayments() {
        $order_id = strtoupper(trim(request('reference')));
        $invoice = DB::table('admin.all_invoices')->where(DB::raw('upper(reference)'), $order_id)->first();
        DB::table($invoice->schema_name . ".invoices")->where('reference', $order_id)->update(['status' => 1]);
        $receipt = strlen(request('transid')) > 3 ? request('transid') : request('receipt');
        $payments = \collect(DB::select('select * from ' . $invoice->schema_name . ".payments where transaction_id='" . $receipt . "'"))->first();
        if (!empty($payments)) {
            $data = strlen(request('transactionRef')) > 3 ?
                    array(
                "status" => 207,
                "statusDesc" => "Fail",
                "data" => array(
                    "Message" => " Transaction reference number already paid ",
                )
                    ) : array(
                'status' => 1,
                'reference' => $invoice->reference,
                'description' => 'Transaction ID has been used already to commit transaction'
            );

            die(json_encode($data));
        }

//this user already paid, save in payments and grant access
        $bank = DB::table($invoice->schema_name . '.bank_accounts_integrations')->where('invoice_prefix', $invoice->prefix)->first();
        $bank_id = !empty($bank) ? $bank->bank_account_id : DB::table($invoice->schema_name . '.bank_accounts_integrations')->first()->bank_account_id;

        $channel = request('transactionChannel') == null ? request('chennel') : request('transactionChannel');
//stora payments
        $payment_array = array(
            'amount' => request('amount'),
            'student_id' => $invoice->student_id,
            'channel' => $channel,
            "date" => 'now()',
            'payment_type_id' => 3,
            "transaction_id" => $receipt,
            'bank_account_id' => $bank_id,
            'token' => request('token'),
            'created_at' => 'now()',
            'reconciled' => 1,
            'status' => 1,
            'amount_entered' => request('amount')
        );
        $payment_id = DB::table($invoice->schema_name . ".payments")->insertGetId($payment_array);
//run distribution
        $this->recordCompanyRevenue($invoice->student_id, $receipt, $invoice->schema_name, $invoice->reference);
        DB::statement('select * from ' . $invoice->schema_name . ' .digital_learning_payment_distribution(' . $payment_id . ',3000)');
// $accept_payment = $invoice_payment->clearPayments($invoice->id, request('amount'), 5, date('Y-m-d'), $receipt, $bank_id, 3000, '','', $invoice->schema_name, request('token'), $channel);
//$query = (object) ($accept_payment);


        $package = DB::table($invoice->schema_name . '.livestudy_packages')->where('id', $invoice->live_package_id)->first();
        if (empty($package)) {
//When someone try to enter amount different from the one we have specified
            $package = DB::table($invoice->schema_name . '.livestudy_packages')->first();
        }
        $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $package->days . ' day'));
        DB::table($invoice->schema_name . '.livestudy_payments')->insert([
            'sid' => $invoice->sid,
            'payment_id' => $payment_id,
            'livestudy_package_id' => $package->id,
            'start_date' => 'now()',
            'end_date' => $end_date
        ]);
        $payment = DB::table($invoice->schema_name . ".payments")->where('id', $payment_id)->first();
        $data = array(
            'status' => 200, 'reference' => $invoice->reference, 'receipt' => $payment->receipt_code,
            'description' => 'Invoice Paid Successfully'
        );
        $message = "RECEIPT : " . $receipt . " confirmed. " . request('currency') . " " . request('amount') . "/= received by " . $invoice->schema_name . " for " . $package->days . " Days, fees on " . date('d/m/Y') . " at " . date('h:i:s A') . " up to " . $end_date . " INVOICE: " . $invoice->reference;

        $users = DB::select('select a.email,a.phone from ' . $invoice->schema_name . '.parent a JOIN ' . $invoice->schema_name . '.student_parents b on b.parent_id=a."parentID" where b.student_id=' . $invoice->student_id);
        foreach ($users as $user) {
            DB::table($invoice->schema_name . ".email")->insert(array('body' => $message, 'subject' => 'Payment Accepted', 'email' => $user->email));
            DB::table($invoice->schema_name . '.sms')->insert(array('phone_number' => $user->phone, 'body' => $message, 'type' => 1));
        }
// $this->notify('Payment Status',$message);
        echo json_encode($data);
    }

    public function recordCompanyRevenue($student_id, $transaction_id, $schema_name, $reference = null) {
        $parent = \collect(DB::select('select a.email,a.phone,a.name from ' . $schema_name . '.parent a JOIN ' . $schema_name . '.student_parents b on b.parent_id=a."parentID" where b.student_id=' . $student_id))->first();

        $note = $reference . ' being payment for Digital Learning, ' . $schema_name;

        $data = [
            'payer_name' => !empty($parent) ? $parent->name : '',
            'payer_phone' => !empty($parent) ? $parent->phone : '',
            'payer_email' => !empty($parent) ? $parent->email : '',
            'created_by_id' => 3,
            'amount' => 305.08,
            "refer_expense_id" => 67,
            "bank_account_id" => 3,
            'payment_method' => ' e-payments',
            'transaction_id' => $transaction_id,
            'date' => 'now()',
            'note' => $note,
            'schema_name' => $schema_name
        ];
        DB::table('admin.revenues')->insert($data);
    }

    /**
     * @deprecated
     */
    public function clearLiveStudyPayment() {
        $order_id = strtoupper(trim(request('reference')));
        $invoice = DB::table('admin.all_invoices')->where(DB::raw('upper(reference)'), $order_id)->first();
        DB::table($invoice->schema_name . ".invoices")->where('reference', $order_id)->update(['status' => 1]);
        $receipt = strlen(request('transactionRef')) > 3 ? request('transactionRef') : request('receipt');
        $payments = \collect(DB::select('select * from ' . $invoice->schema_name . ".payments where transaction_id='" . $receipt . "'"))->first();
        if (!empty($payments)) {
            $data = strlen(request('transactionRef')) > 3 ?
                    array(
                "status" => 207,
                "statusDesc" => "Fail",
                "data" => array(
                    "Message" => " Transaction reference number already paid ",
                )
                    ) : array(
                'status' => 1,
                'reference' => $invoice->reference,
                'description' => 'Transaction ID has been used already to commit transaction'
            );

            die(json_encode($data));
        }
//this user already paid, save in payments and grant access
        $payment_array = array(
            'amount' => $invoice->amount,
            "invoice_id" => $invoice->id,
            'student_id' => $invoice->student_id,
            'channel' => request('channel'),
            "date" => 'now()',
            'payment_type_id' => 3,
            "transaction_id" => $receipt,
            'bank_account_id' => DB::table($invoice->schema_name . '.bank_accounts')->first()->id,
            'token' => '',
            'created_at' => 'now()',
            'reconciled' => 1,
            'amount_entered' => $invoice->amount
        );
        $payment_id = DB::table($invoice->schema_name . ".payments")->insertGetId($payment_array);
        $package = DB::table($invoice->schema_name . '.livestudy_packages')->where('id', $invoice->live_package_id)->first();
        if (empty($package)) {
//When someone try to enter amount different from the one we have specified
            $package = DB::table($invoice->schema_name . '.livestudy_packages')->first();
        }
        $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $package->days . ' day'));
        DB::table($invoice->schema_name . '.livestudy_payments')->insert([
            'sid' => $invoice->sid,
            'payment_id' => $payment_id,
            'livestudy_package_id' => $package->id,
            'start_date' => 'now()',
            'end_date' => $end_date
        ]);
        $payment = DB::table($invoice->schema_name . ".payments")->where('id', $payment_id)->first();
        $data = array(
            'status' => 1, 'reference' => $invoice->reference, 'receipt' => $payment->receipt_code,
            'description' => 'Invoice Paid Successfully'
        );
        $message = "RECEIPT : " . $receipt . " confirmed. " . request('currency') . " " . request('amount') . "/= received by " . $invoice->schema_name . " for " . $package->days . " Days, fees on " . date('d/m/Y') . " at " . date('h:i:s A') . " up to " . $end_date . " INVOICE: " . $invoice->reference;


        $users = DB::select('select a.email,a.phone from ' . $invoice->schema_name . '.parent a JOIN ' . $invoice->schema_name . '.student_parents b on b.parent_id=a."parentID" where b.student_id=' . $invoice->student_id);
        foreach ($users as $user) {
            DB::table($invoice->schema_name . ".email")->insert(array('body' => $message, 'subject' => 'Payment Accepted', 'email' => $user->email));
            DB::table($invoice->schema_name . '.sms')->insert(array('phone_number' => $user->phone, 'body' => $message, 'type' => 1));
        }
        echo json_encode($data);
    }

    public function getInvoiceDetail() {
        $schema = '';
        if (preg_match('/EA/', $this->reference)) {
            $original_invoice = explode('EA', $this->reference)[0];
            $invoice_view = \collect(DB::select('select * from admin.all_invoices where upper(reference) = \'' . strtoupper($original_invoice) . "'"))->first();

            if (empty($invoice_view)) {

                die(json_encode(array(
                    'status' => 0,
                    'reference' => $this->reference,
                    'description' => 'This invoice does not exists in the ShuleSoft'
                )));
            }
            $schema = $invoice_view->schema_name;

            $invoice = DB::table($invoice_view->schema_name . '.invoice_subviews')->where(DB::raw('upper(reference)'), strtoupper($this->reference))->first();
        } else {

            $invoice_view = \collect(DB::select('select * from admin.all_invoices where upper(reference) = \'' . strtoupper($this->reference) . "'"))->first();

            if (empty($invoice_view)) {

                die(json_encode(array(
                    'status' => 0,
                    'reference' => $this->reference,
                    'description' => 'This invoice does not exists in the ShuleSoft'
                )));
            }
            $schema = $invoice_view->schema_name;
            $invoice = DB::table($invoice_view->schema_name . '.invoice_views')->where(DB::raw('upper(reference)'), strtoupper($this->reference))->first();
        }
        return [$schema, $invoice];
    }

    /**
     * @return JSON OBJECT 
     */
    private function secondRequest() {

        $this->checkEmptyKeys();


        $get = $this->getInvoiceDetail();
        $schema = $get[0];
        $invoice = $get[1];


//temp for DIGITAL learning
        if (preg_match('/TZ/i', strtoupper(request('reference')))) {
            return $this->clearLiveStudyPayments();
        }
        if (!empty($invoice)) {
// This is when a bank return payment status to us
//save it in the database
            $receipt = strlen(request('transactionRef')) > 3 ? request('transactionRef') : request('receipt');
            $payments = \collect(DB::select('select * from ' . $schema . ".payments where transaction_id='" . $receipt . "'"))->first();
            if (!empty($payments)) {
                $data = strlen(request('transactionRef')) > 3 ?
                        array(
                    "status" => 207,
                    "statusDesc" => "Fail",
                    "data" => array(
                        "Message" => " Transaction reference number already paid ",
                    )
                        ) : array(
                    'status' => 1,
                    'reference' => $invoice->reference,
                    'description' => 'Transaction ID has been used already to commit transaction'
                );

                die(json_encode($data));
            }

            $invoice_payment = new Invoices();
            $received_amount = $this->request_value('amount');
            $setting = DB::table($schema . '.setting')->select('transaction_charges_to_parents', 'transaction_fee')->first();
            if ($setting->transaction_charges_to_parents == 1) {
//reduce transaction fee
                $amount = $received_amount - $setting->transaction_fee;
            } else {
                $amount = $received_amount;
            }

            $bank_records = DB::table($schema . '.bank_accounts')->where('number', request('account_number'))->first();
            if (empty($bank_records)) {
                $bank_records = DB::table($schema . '.bank_accounts')->first();
                $this->send_email('inetscompany@gmail.com', 'Bank deposit security issue', "Bank Account " . request('account_number') . ' is not registered in the sytem. Money has  been deposited in ' . request('account_number') . ' and allocated default bank account number ' . $bank_records->number . ' in shulesoft');
            }
//$payment_type = DB::table('constant.payment_types')->first();
            $channel = request('transactionChannel') == null ? request('chennel') : request('transactionChannel');
//$this->recordCompanyRevenue($invoice->student_id, $receipt, $schema, $invoice->reference);

            $option_param = [
//special case for CRDB payments only
                'checksum' => $this->request_value('checksum'),
                'payment_type' => $this->request_value('paymentType'),
                'amount_type' => $this->request_value('amountType'),
                'currency' => $this->request_value('currency')
            ];
            $accept_payment = $invoice_payment->clearPayments($invoice->id, $amount, 5, date('Y-m-d'), $receipt, $bank_records->id, $invoice->fee_id, '', '', $schema, request('token'), $channel);

            $query = (object) ($accept_payment);

            $last_invoice = $this->getInvoiceDetail()[1];
            if ($invoice->amount - $last_invoice->amount > 0) {
                $receipt = \collect(DB::select('select * from ' . $schema . '.payments where "id"=' . $query->payment_id))->first();

//payment has been done succesffully
                if ($schema == 'accounts') {
                    
                } else {
//successful, I will change this to the correct SQL
// send SMS to users who have the invoice, and not the phone number used to make payment
                    $message = "RECEIPT : " . $receipt->receipt_code . " confirmed. " . request('currency') . " " . request('amount') . "/= received by " . $schema . " for " . $invoice->name . " fees on " . date('d/m/Y') . " at " . date('h:i:s A') . " INVOICE: " . $invoice->reference;

                    $users = DB::select('select a.email,a.phone from ' . $schema . '.parent a JOIN ' . $schema . '.student_parents b on b.parent_id=a."parentID" where b.student_id=' . $invoice->student_id);
                    foreach ($users as $user) {
                        DB::table($schema . ".email")->insert(array('body' => $message, 'subject' => 'Payment Accepted', 'email' => $user->email));
                        DB::table($schema . '.sms')->insert(array('phone_number' => $user->phone, 'body' => $message, 'type' => 1));
                    }
                }
//return feedback to a bank to send SMS too

                $data = strlen(request('transactionRef')) > 3 ? array("status" => 200, "statusDesc" => "success",
                    "data" => array(
                        "receipt" => $receipt->receipt_code
                    )) :
                        array(
                    'status' => 1, 'reference' => $invoice->reference, 'receipt' => $receipt->receipt_code,
                    'description' => 'Invoice Paid Successfully'
                );

                echo json_encode($data);
            } else if ($invoice->amount == $last_invoice->amount) {
//payment is duplicated, already received
//$user = $this->Payment_modal->get_receipt_from_booking($this->api_param['invoice']);

                $data = strlen(request('transactionRef')) > 3 ?
                        array(
                    "status" => 206,
                    "statusDesc" => "Fail",
                    "data" => array(
                        "Message" => " Duplicate entry ",
                    )
                        ) : array(
                    'status' => 0,
                    'reference' => $invoice->reference,
                    'description' => 'Invoice Failed to be paid'
                );
                echo json_encode($data);
            }
        } else {
//we don't have this invoice
            $data = strlen(request('transactionRef')) > 3 ?
                    array(
                "status" => 204,
                "statusDesc" => "Fail",
                "data" => array(
                    "Message" => "Invalid payment reference number",
                )
                    ) : array(
                'status' => 0,
                'reference' => request('reference'),
                'description' => 'Unknown reference number'
            );
            echo json_encode($data);
        }
    }

    /**
     * @return JSON OBJECT
     */
    public function api() {
        /*         * -------------payment flow will be as follows-----------------

         * 1. validate api_key and api_secret by checking in the database
          2. if the request=1, take the invoice form the database and send it to client with
          request id, status,param (invoice, amount,currency,account)
          3. if request is 2, then we expect to receive payment information from a bank
          and the status if the payment is complete or not, if complete, we return
          to client request, status, param (invoice, receipt)
         */

        $this->api_param = request()->all();
        $request = $this->init_api_request();

//$this->db_status_connect();
        switch ($request) {
            case 1:
//this is the first request from a bank
// fetch user request and send parameters to us
                $this->firstRequest();
                break;
            case 2:
//this is the second request from a bank with the same invoice no
                DB::beginTransaction();
                $this->secondRequest();
                DB::commit();
                break;
            default:
                $data['request'] = 1;
                $data['status'] = 3;
                $data['param'] = array(
                    'reference' => 'NILL',
                    'description' => 'Unknown request'
                );
                echo json_encode($data);
                break;
        }
    }

    /**
     * @uses Payment comparison report between brela staff and respective bank
     */
 

    function reconcile() {
        $payment_id = request('id');
        $type = request('type');
        $table = request('table');
        if ($table == 'total_expenses') {
            $payment = \App\Model\Expense::find($payment_id);
            !empty($payment) ? $payment->update(['reconciled' => 1]) : '';
        } else {
            $payment = $type == 1 ? \App\Model\Payment::find($payment_id) : \App\Model\Revenue::find($payment_id);
            !empty($payment) ? $payment->update(['reconciled' => 1]) : '';
        }
        echo 'success';
    }

    function unreconcile() {
        $payment_id = request('id');
        $type = request('type');
        $payment = $type == 1 ? \App\Model\Payment::find($payment_id) : \App\Model\Revenue::find($payment_id);
        $payment->reconciled = 0;
        $payment->save();
        echo 'success';
    }

    private function checkKeysExists($value) {
        $required = array('amount', 'roll', 'academic_year', 'payment_type', 'date', 'transaction_id', 'account_number');


        $data = array_change_key_case(array_shift($value), CASE_LOWER);
        $keys = str_replace(' ', '_', array_keys($data));
        $results = array_combine($keys, array_values($data));
        if (count(array_intersect_key(array_flip($required), $results)) === count($required)) {
//All required keys exist!            
            $status = 1;
        } else {
            $missing = array_intersect_key(array_flip($required), $results);
            $data_miss = array_diff(array_flip($required), $missing);
            $status = ' Column with title <b>' . implode(', ', array_keys($data_miss)) . '</b>  miss from Excel file. Please make sure file is in the same format as a sample file';
        }

        return $status;
    }

    public function uploadPaymentFile() {
        $this->data["subview"] = "error";
        return view('payment.upload_excel', $this->data);
    }

    public function uploadByExcel($account_data = null) {
        if (!empty($_POST)) {
            $data = $account_data == null ? $this->uploadExcel() : $account_data;
            $status = $this->checkKeysExists($data);
            foreach ($data as $value) {
                DB::table('tempfiles')->insert(['data' => json_encode($value), 'filename' => request('file')->getClientOriginalExtension(), 'created_by' => session('id'), 'created_by_table' => session('table'), 'method' => 'uploadPayments', 'controller' => 'PaymentController']);
            }
            if ((int) $status == 1) {
                $status = 'File have uploaded successfully and processed on the background. Soon you will be notified once ShuleSoft processed your file <br/>'
                        . 'To view uploading progress, <a href="' . url('background/fileuploads') . '">click here</a> ';
            }
            if ($account_data == null) {
                $this->data['status'] = $status;
                $this->data["subview"] = "mark/upload_status";
                $this->load->view('_layout_main', $this->data);
            } else {
                return '<b> Payments:</b> ' . $status;
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * @used Generate payment receipt to a user
     * @depends payment_insertion
     * @var session_id=session from someone who log in
     * @var payment_id
     */
//    function code($nc = 6, $a = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789') {
//        $l = strlen($a) - 1;
//        $r = '';
//        while ($nc-- > 0)
//            $r .= $a{mt_rand(0, $l)};
//
//        return $r;
//    }

    /*
     * *  Function:   convert_number
     * *  Arguments:  int
     * *  Returns:    string
     * *  Description:
     * *      Converts a given integer (in range [0..1T-1], inclusive) into
     * *      alphabetical format ("one", "two", etc.).
     */

    public function convert_number($number) {
        if (($number < 0) || ($number > 999999999)) {
            return "$number";
        }

        $Gn = floor($number / 1000000);  /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);     /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);      /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);       /* Tens (deca) */
        $n = $number % 10; /* Ones */

        $res = "";

        if ($Gn) {
            $res .= $this->convert_number($Gn) . " Million";
        }

        if ($kn) {
            $res .= (empty($res) ? "" : " ") .
                    $this->convert_number($kn) . " Thousand";
        }

        if ($Hn) {
            $res .= (empty($res) ? "" : " ") .
                    $this->convert_number($Hn) . " Hundred";
        }

        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
            "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
            "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
            "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
            "Seventy", "Eigthy", "Ninety");

        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " and ";
            }

            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];

                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = "zero";
        }

        return $res;
    }

}