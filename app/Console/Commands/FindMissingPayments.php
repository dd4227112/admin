<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class FindMissingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find Missing Payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $invoices = DB::select('SELECT "schema_name", invoice_prefix as prefix from admin.all_bank_accounts_integrations where api_username is not null and api_password is not null');
        $returns = [];
        $background = new \App\Http\Controllers\Background();
        //Find All Payment on This Dates
        $dates = new \DatePeriod(
                new \DateTime(date('Y-m-d', strtotime('-30 days'))), new \DateInterval('P1D'), new \DateTime(date('Y-m-d', strtotime('2 days')))
        );
        //To iterate
        foreach ($dates as $key => $value) {
            foreach ($invoices as $invoice) {
                $token = $background->getToken($invoice);
                $prefix = $invoice->prefix;
                if (strlen($token) > 4) {
                    $fields = array(
                        "reconcile_date" => $value->format('d-m-Y'),
                        "token" => $token
                    );
                    $push_status = 'reconcilliation';
                    $url = $invoice->schema_name == 'beta_testing' ?
                            'https://wip.mpayafrica.com/v2/' . $push_status : 'https://api.mpayafrica.co.tz/v2/' . $push_status;
                    $curl = $background->curlServer($fields, $url);
                    array_push($returns, json_decode($curl));
                    foreach ($returns as $return) {
                        $data = $return->transactions;
                        if (!empty($data)) {
                            $trans = (object) $data;
                            $i = 1;
                            foreach ($trans as $tran) {
                                if (preg_match('/' . strtolower($prefix) . '/i', strtolower($tran->reference))) {
                                    $check = DB::table($invoice->schema_name . '.payments')->where('transaction_id', $tran->receipt)->first();
                                    if (empty($check)) {
                                        $this->syncMissingPayments(json_encode($tran), $invoice->schema_name, $tran->customer_name, $tran->amount, $tran->timestamp);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return 0;
    }
    public function syncMissingPayments($data, $schema, $student = null, $amount = null, $date = '') {
        $controller = new \App\Http\Controllers\Controller();
        $background = new \App\Http\Controllers\Background();
        $url = 'http://75.119.140.177:8081/api/init';
        $fields = json_decode($data);
        $curl = $background->curlServer($fields, $url, 'row');
        $status = json_decode($curl);
        if (isset($status->status) && $status->status == 0) {
            $reference = isset($status->reference) ? $status->reference : '';
            $message = isset($status->description) ? $status->description : '';
            $sms = 'Hello, this Invoice ' . $reference . ' of ' . $student . ' from *' . strtoupper($schema) . '* with paid amount of ' . $amount . ' failed to be paid. With Error message: ' . chr(10) . chr(10) . $message . ' happened on ' . $date . ' Take a look';
            $whatsapp_numbers = ['255714825469'];
            foreach ($whatsapp_numbers as $number) {
                $controller->sendMessage($number . '@c.us', $sms);
            }
        }
        return $curl;
    }
}
