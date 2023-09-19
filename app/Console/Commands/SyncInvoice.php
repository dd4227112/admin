<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncInvoice extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Invoices';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * @param type $fields
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $schema
     * @return type
     *             $user = '107M17S666D381';
      $pass = 'rWh$abB!P5&$MWvj$!DTe29F#vAu2tmct!2';
     * 
      Username: 109M17SA01DINET
      Password : LuHa6bAjKV5g5vyaRaRZJy*x5@%!yBBBTVy  , mother of mercy
     */
    public function getToken($invoice) {
        if ($invoice->schema_name == 'beta_testing') {
            //testing invoice
            //  $setting = DB::table('public.setting')->first();
            $url = 'https://wip.mpayafrica.com/v2/auth';
            $credentials = DB::table('admin.all_bank_accounts_integrations')->where('invoice_prefix', $invoice->prefix)->first();
            if (!empty($credentials)) {
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
            if (!empty($credentials)) {
                $user = trim($credentials->api_username);
                $pass = trim($credentials->api_password);
            } else {
//                $credentials = DB::table($invoice->schema_name . '.bank_accounts_integrations')->first();
//                $user = trim($credentials->api_username);
//                $pass = trim($credentials->api_password);
                return DB::table('api.requests')->insert(['return' => '', 'content' => 'invalid credentials for ' . $invoice->schema_name]);
            }
        }
        $request = $this->curlServer([
            'username' => $user,
            'password' => $pass
                ], $url);
        $obj = json_decode($request);

        DB::table('api.requests')->insert(['return' => json_encode($obj), 'content' => json_encode($request), 'header' => $invoice->schema_name]);
        if (isset($obj) && is_object($obj) && isset($obj->status) && $obj->status == 1) {
            return $obj->token;
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        DB::select('select shulesoft.update_negative_student()');
        return false;
        $invoices = DB::select("select distinct a.schema_name from admin.all_bank_accounts_integrations  a JOIN admin.all_bank_accounts b on(a.bank_account_id=b.id  AND a.schema_name=b.schema_name) where b.refer_bank_id=22 and a.schema_name not in ('public') ");
        foreach ($invoices as $invoice) {
            $this->syncInvoicePerSchool($invoice->schema_name);
        }
        echo '>> Invoice Sync Completed : Count ' . count($invoices) . chr(10);
        return 0;
    }

    public function syncInvoicePerSchool($schema = '') {
        $invoices = DB::select("select b.invoice_id as id, d.student_id, b.status, b.reference, b.prefix,d.date,b.sync,b.return_message,b.push_status,d.academic_year_id, "
                        . " b.created_at, b.updated_at, a.amount, c.name as student_name, '" . $schema . "' as schema_name, (select sub_invoice from "
                        . "  " . $schema . ".setting limit 1) as sub_invoice   from   " . $schema . ".invoice_prefix b JOIN  " . $schema . ".invoices d on b.invoice_id=d.id  join " . $schema . ".student c on c.student_id=d.student_id join (select sum(balance) as amount, a.invoice_id from " . $schema . ".invoice_balances a "
                        . " group by a.invoice_id ) a on a.invoice_id=d.id where b.sync <>1 and b.prefix in "
                        . " (select bn.invoice_prefix from " . $schema . ".bank_accounts_integrations bn join " . $schema . ".bank_accounts ba on "
                        . " ba.id=bn.bank_account_id where ba.refer_bank_id=22 AND bn.api_username is not null) order by random() limit 120");

        foreach ($invoices as $invoice) {
            if ($invoice->sub_invoice == 1) {
                echo 'push sub invoices for ' . $invoice->schema_name . '' . chr(10) . chr(10);
                $sub_invoices = DB::select("select b.id,b.status, b.student_id, b.reference||'EA'||a.fee_id as reference, b.prefix,b.date,b.sync,b.return_message,b.push_status,b.academic_year_id,b.created_at, b.updated_at, a.balance as amount, c.name as student_name, '" . $schema . "' as schema_name from  " . $schema . ".invoices b join " . $schema . ".student c on c.student_id=b.student_id join " . $schema . ".invoice_balances a on a.invoice_id=b.id  where b.id=" . $invoice->id);

                foreach ($sub_invoices as $sub_invoice) {
                    $this->pushInvoice($sub_invoice);
                }
            } else {
                echo 'push Normal  invoices for ' . $invoice->schema_name . '' . chr(10) . chr(10);
                $this->pushInvoice($invoice);
            }
        }
    }

    public function pushInvoice($invoice) {
        $token = $this->getToken($invoice);
        if (strlen($token) > 4) {
            $fields = array(
                "reference" => trim($invoice->reference),
                "student_name" => isset($invoice->student_name) ? $invoice->student_name : '',
                "student_id" => $invoice->student_id,
                "amount" => $invoice->amount,
                "allow_partial" => "TRUE",
                "type" => ucfirst($invoice->schema_name) . '  School fee',
                "code" => "10",
                "callback_url" => "http://75.119.140.177:8081/api/init",
                "token" => $token
            );
            echo 'Status no ' . $invoice->status . ' runs for schema ' . $invoice->schema_name . chr(10) . chr(10);
            switch ($invoice->status) {
                case 2:

                    $this->updateInvoiceStatus($fields, $invoice, $token);
                    break;
                case 3:
                    $this->deleteInvoice($invoice, $token);

                    break;
                case 4:
                    $this->validateInvoice($invoice, $token);

                    break;
                default:
                    $this->pushStudentInvoice($fields, $invoice, $token);
                    break;
            }
        } else {
            echo 'No token generated for ' . $invoice->schema_name . chr(10) . chr(10);
        }
    }

    public function updateInvoiceStatus($fields, $invoice, $token) {
        $push_status = 'invoice_update';
        if ($invoice->schema_name == 'beta_testing') {
            //testing invoice
            $setting = DB::table('public.setting')->first();
            $url = 'https://wip.mpayafrica.com/v2/' . $push_status;
        } else {
            //live invoice
            $setting = DB::table($invoice->schema_name . '.setting')->first();
            $url = 'https://api.mpayafrica.co.tz/v2/' . $push_status;
        }
        echo 'invoice update' . $invoice->schema_name;
        $curl = $this->curlServer($fields, $url);
        $result = json_decode($curl);

        if (isset($result) && !empty($result) && isset($invoice->student_id)) {
            //update invoice no
            DB::table($invoice->schema_name . '.invoice_prefix')->where('reference', $invoice->reference)->update(['sync' => 1, 'return_message' => $curl, 'push_status' => $push_status, 'updated_at' => 'now()']);
        }
        DB::table('api.requests')->insert(['return' => json_encode($curl), 'content' => json_encode($fields)]);
    }

    public function deleteInvoice($invoice, $token) {
        if (strlen($token) > 4) {
            $fields = array(
                "reference" => trim($invoice->reference),
                "token" => $token
            );

            $push_status = 'invoice_cancel';

            echo $push_status . $invoice->schema_name;
            if ($invoice->schema_name == 'beta_testing') {
                //testing invoice
                $setting = DB::table('public.setting')->first();
                $url = 'https://wip.mpayafrica.com/v2/' . $push_status;
            } else {
                //live invoice
                $setting = DB::table($invoice->schema_name . '.setting')->first();
                $url = 'https://api.mpayafrica.co.tz/v2/' . $push_status;
            }
            $curl = $this->curlServer($fields, $url);
            $result = json_decode($curl);
            if (isset($result) && !empty($result) && isset($invoice->student_id)) {
                //update invoice no
                DB::table($invoice->schema_name . '.invoice_prefix')->where('reference', $invoice->reference)->update(['sync' => 0, 'status' => 0, 'return_message' => $curl, 'push_status' => 'delete_' . $push_status, 'updated_at' => 'now()']);
            } else {
                DB::table($invoice->schema_name . '.revenues')->where('reference', $invoice->reference)->update(['status' => 0, 'updated_at' => 'now()']);
            }

            DB::table('api.requests')->insert(['return' => json_encode($curl), 'content' => json_encode($fields)]);
        }
    }

    public function validateInvoice($invoice, $token) {
        $fields = array(
            "reference" => trim($invoice->reference),
            "token" => $token
        );
        $push_status = 'check_invoice';

        echo $push_status . $invoice->schema_name;
        if ($invoice->schema_name == 'beta_testing') {
            //testing invoice
            $setting = DB::table('public.setting')->first();
            $url = 'https://wip.mpayafrica.com/v2/' . $push_status;
        } else {
            //live invoice
            $setting = DB::table($invoice->schema_name . '.setting')->first();
            $url = 'https://api.mpayafrica.co.tz/v2/' . $push_status;
        }
        $curl = $this->curlServer($fields, $url);
        $result = json_decode($curl);
        print_r($result);
        if (isset($result) && !empty($result)) {
            //check invoice and compare with the action
            if ($result->status == 1) {
                //we are goood, check if all inputs are matched, or else delete and resent it
                $data = (object) $result->data;
                if (strtolower($data->student_name) == strtolower($invoice->student_name) && strtolower($data->student_id) == strtolower($invoice->student_id) && strtolower($data->callback_url) == 'http://75.119.140.177:8081/api/init') {

                    //all is well, so just update status to be okay
                    DB::table($invoice->schema_name . '.invoice_prefix')->where('reference', $invoice->reference)->update(['sync' => 1, 'status' => 1, 'return_message' => $curl, 'push_status' => 'check_' . $push_status, 'updated_at' => 'now()']);
                } else {
                    //update the whole invoice
                    $new_token = $this->getToken($invoice);
                    $fields = array(
                        "reference" => trim($invoice->reference),
                        "student_name" => isset($invoice->student_name) ? $invoice->student_name : '',
                        "student_id" => $invoice->student_id,
                        "amount" => $invoice->amount,
                        "type" => ucfirst($invoice->schema_name) . '  School fee',
                        "code" => "10",
                        "callback_url" => "http://75.119.140.177:8081/api/init",
                        "token" => $new_token
                    );
                    echo chr(10) . ' final invoice status ' . chr(10);
                    print_r($fields);
                    $this->updateInvoiceStatus($fields, $invoice, $new_token);
                }
            } else {
                //invoice is not found, so update for it to be sync
                DB::table($invoice->schema_name . '.invoices')
                        ->where('id', $invoice->id)->update(['sync' => 0, 'status' => 0, 'return_message' => $curl, 'push_status' => 'check_' . $push_status, 'updated_at' => 'now()']);
            }
        }

        DB::table('api.requests')->insert(['return' => json_encode($curl), 'content' => json_encode($fields)]);
    }

    public function pushStudentInvoice($fields, $invoice, $token) {
        $push_status = 'invoice_submission';

        echo $push_status . $invoice->schema_name;
        if ($invoice->schema_name == 'beta_testing') {
            //testing invoice
            $setting = DB::table('public.setting')->first();
            $url = 'https://wip.mpayafrica.com/v2/' . $push_status;
        } else {
            //live invoice
            $setting = DB::table($invoice->schema_name . '.setting')->first();
            $url = 'https://api.mpayafrica.co.tz/v2/' . $push_status;
        }
        $curl = $this->curlServer($fields, $url);
        $result = json_decode($curl);
        print_r($result);
        echo chr(10);

        if (isset($result) && !empty($result) && isset($invoice->student_id) && (int) $invoice->student_id > 0) {
            //update invoice no
            DB::table($invoice->schema_name . '.invoice_prefix')->where('reference', $invoice->reference)->update(['sync' => 1, 'return_message' => $curl, 'push_status' => $push_status, 'updated_at' => 'now()']);
        } else {
            DB::table($invoice->schema_name . '.revenues')->where('reference', $invoice->reference)->update(['status' => 1, 'updated_at' => 'now()']);
        }
        DB::table('api.requests')->insert(['return' => json_encode($curl), 'content' => json_encode($fields)]);
    }

    private function curlServer($fields, $url) {
// Open connection
        $ch = curl_init();
// Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/x-www-form-urlencoded'
        ));

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
