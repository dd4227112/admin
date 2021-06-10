<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Message;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Background;
use DB;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
// \App\Console\Commands\Inspire::class,
    ];
// public   $email_log = 'email_'.str_replace('-', '_', date('Y-M-d')) . '.html';
// public   $sms_log = 'sms_'.str_replace('-', '_', date('Y-M-d')) . '.html';
    public $emails;

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        //$schedule->call(function () {
        //     $this->save_car_track_access_token('public');
        // })->everyTwoHours();
        // $schedule->call(function () {
        //     $this->car_track_alert_parent('public'); 
        // })->everyTwoHours();
        // $schedule->call(function () {
        //     $this->addAttendance(); 
        // })->everySixHours();
        // $schedule->command('inspire')
        //         ->hourly();
        $schedule->call(function () {
            //sync invoices 
            $this->syncInvoice();
           // $this->updateInvoice();
        })->everyMinute();

        // $schedule->call(function () {
        //     // End Deadlock Processes 
        //     $this->endDeadlock();
        // })->everyThreeMinutes();
//        $schedule->call(function () {
//            (new Message())->sendSms();
//        })->everyMinute();
        // $schedule->call(function () {
        //     (new Message())->checkPhoneStatus();
        // })->hourly();
        // $schedule->call(function () {
        //   $this->curlServer(['action' => 'payment'], 'http://51.77.212.234:8081/api/cron');
        // (new Message())->sendEmail();
        ///  })->everyMinute();
//  $schedule->call(function () {
        //(new Message())->karibusmsEmails();
        // })->everyMinute();
        // $schedule->call(function () {
        //     // remind parents to login in shulesoft and check their child performance
        //     $this->sendTodReminder();
        // })->dailyAt('03:30'); // Eq to 06:30 AM 

        // $schedule->call(function () { 

        //     $this->sendNotice();
        //     $this->sendBirthdayWish();
        //     $this->sendTaskReminder();
        //     // $this->sendSequenceReminder();
        // })->dailyAt('04:40'); // Eq to 07:40 AM   

        $schedule->call(function () { 
            $this->sendSORemainder();
        })->dailyAt('04:40'); // Eq to 07:40 AM 
          
//        $schedule->call(function() {
//            //send login reminder to parents in all schema
//            $this->sendLoginReminder();
//        })->fridays()->at('9:00');
//
//        $schedule->call(function() {
//            //send login reminder to parents in all schema
//            //$this->notifyUsersDailyReports();
//        })->weekly()->weekdays()->at('13:00');
//
        // $schedule->call(function () {
        //     // send Birdthday 
        //     // $this->sendReportReminder();
        //     (new Message())->paymentReminder();
        // })->dailyAt('05:10');
        // $schedule->call(function () {
        //     $this->checkSchedule();
        // })->everyMinute();
        // $schedule->call(function () {
        //     //  (new HomeController())->createTodayReport();
        //     (new Background())->officeDailyReport();
        // })->dailyAt('14:50'); // Eq to 17:50 h 
        $schedule->call(function () {
            //     //  (new HomeController())->createTodayReport();
            (new Background())->schoolMonthlyReport();
        })->monthlyOn(29, '06:36');
    }

    function checkPaymentPattern($user, $schema) {
        $pattern = [0, 0, 0];
        if ($user->table == 'parent') {
            $sql = 'select  coalesce(coalesce(sum(a.total_amount),0)-sum(a.discount_amount),0) as amount, coalesce(coalesce(sum(a.total_payment_invoice_fee_amount),0)+ coalesce(sum(a.total_advance_invoice_fee_amount)),0) as paid_amount, sum(a.balance) as balance, a.invoice_id as id,a.student_id, c.reference, b.name as student_name, a.created_at,f.phone,f.name as parent_name,f.username from ' . $schema . '. invoice_balances a join ' . $schema . '.student b on a.student_id=b.student_id JOIN  ' . $schema . '.student_parents e on e.student_id=b.student_id join ' . $schema . '.parent f on f."parentID"=e.parent_id JOIN  ' . $schema . '.invoices c on c.id=a.invoice_id where e.parent_id=' . $user->id . ' and  a.student_id in (select student_id from ' . $schema . '.student_archive where section_id in (select "sectionID" FROM ' . $schema . '.section ) )  group by a.invoice_id,a.created_at,b.name ,a.student_id,c.reference,f.phone,f.name,f.username ';
            $parent = \collect(DB::select($sql))->first();
            if (!empty($parent)) {
                $pattern = [$parent->balance, $parent->student_name, $parent->reference];
            }
        }
        return $pattern;
    }

    public function saveSms($schema, $phone, $body, $user_id) {
        return DB::table($schema . '.sms')->insert(array('phone_number' => $phone,
                    'body' => $body,
                    'user_id' => $user_id,
                    'type' => 0));
    }

    public function saveEmail($schema, $email, $body, $user_id, $title) {
        return DB::table($schema . '.email')->insert(array('email' => $email,
                    'body' => $body,
                    'user_id' => $user_id,
                    'subject' => $title));
    }

    public function sendReminder($schedule) {
        if (count(explode(',', $schedule->user_id)) > 0) {
            $users = DB::table($schedule->schema_name . '.users')->whereIn('id', explode(',', $schedule->user_id))->where('role_id', $schedule->role_id)->where('status', '1')->get();
            // $users = DB::table($schedule->schema_name . '.users')->whereIn('id', explode(',', $schedule->user_id))->where('role_id', $schedule->role_id)->get();

            $check_payment_pattern = (preg_match('/#balance/i', $schedule->message) || preg_match('/#invoice/i', $schedule->message)) ? 1 : 0;
            foreach ($users as $user) {
                $payment_pattern = $check_payment_pattern == 1 ? $this->checkPaymentPattern($user, $schedule->schema_name) : [];
                $patterns = array(
                    '/#name/i', '/#username/i', '/#balance/i', '/#student_name/i', '/#invoice/i'
                );
                $replacements = count($payment_pattern) > 0 ? array(
                    $user->name, $user->username, $payment_pattern[0], $payment_pattern[1], $payment_pattern[2]) : array($user->name, $user->username, 0, 0, 0
                );
                $body = preg_replace($patterns, $replacements, $schedule->message);
                if ($schedule->type == 2) { //email
                    $this->saveEmail($schedule->schema_name, $user->email, $body, $user->id, $schedule->title);
                } else if ($schedule->type == 1) {
                    $this->saveSms($schedule->schema_name, $user->phone, $body, $user->id);
                } else {
                    $this->saveSms($schedule->schema_name, $user->phone, $body, $user->id);
                    $this->saveEmail($schedule->schema_name, $user->email, $body, $user->id, $schedule->title);
                }
            }
        }
    }

    public function checkSchedule() {
        $messages = DB::select("select \"messageID\",attach,attach_file_name,schema_name from admin.all_message where attach is not null and attach_file_name  not like '%amazon%' limit 100");
        foreach ($messages as $message) {
            $file = '/usr/share/nginx/html/shulesoft_live/storage/uploads/attach/' . $message->attach_file_name;
            if (file_exists($file)) {
                $path = \Storage::disk('s3')->put('attach', $file);
                $url = \Storage::disk('s3')->url($path);
                DB::table($message->schema_name . '.files')->insert([
                    'mime' => basename($file),
                    'name' => basename($file),
                    'display_name' => basename($file),
                    'user_id' => session('id'),
                    'table' => session('table'),
                    'size' => filesize($file),
                    'caption' => basename($file),
                    'path' => $url
                ]);
                if (strlen($url) > 5) {
                    DB::table($message->schema_name . '.message')->where('messageID', $message->messageID)->update(['attach_file_name' => $url]);
                    echo $message->schema_name . ' Files ' . $file . ' transferred to ' . $url . '<br/>';
                    unlink($file);
                }
            } else {
                echo 'file ' . $file . ' does not exists<br/>';
            }
        }
        $schedules = DB::table('admin.all_reminders')->get();
        $current_time = date('H:i', strtotime(date('H:i')) + (60 * 60 * 3 - 60 * 2)); // plus +3 GMT hours to match with Tanzania time
        //   $current_time = date('H:i');
        foreach ($schedules as $schedule) {
            if (strlen($schedule->days) > 4) {
                $days = explode(',', $schedule->days);

                if (in_array(date('l'), $days) && $current_time == date('H:i', strtotime($schedule->time))) {
                    //execute command
                    $this->sendReminder($schedule);
                }
            } else {
                $day = $schedule->date;
                if (date('dmY', strtotime($day)) == date('dmY') && $current_time == date('H:i', strtotime($schedule->time))) {
                    $this->sendReminder($schedule);
                }
            }
        }
    }

    function notifyUsersDailyReports() {
        $users = DB::select('select * from admin.users');
        foreach ($users as $user) {
            $message = 'Hello ' . $user->firstname . ' ' . $user->lastname . '. Kindly remember to submit your daily marketing/sales report in your hubspot account. Thank you';
            DB::table('public.sms')->insert([
                'body' => $message,
                'phone_number' => $user->phone,
                'type' => 0
            ]);
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
        return implode(',', $uq_names);
    }

    public function syncInvoice() {
        $invoices = DB::select("select distinct schema_name from admin.all_bank_accounts_integrations where invoice_prefix in (select prefix from admin.all_invoices where schema_name not in ('public','accounts','beta_testing')  and sync=0) and invoice_prefix like '%SAS%'");

        foreach ($invoices as $invoice) {
            $this->syncInvoicePerSchool($invoice->schema_name);
        }
    }

    /**
     * Temporarily only allows digital invoice but must support both
     */
    public function syncInvoicePerSchool($schema = '') {

        $invoices = DB::select("select b.id, b.student_id, b.status, b.reference, b.prefix,b.date,b.sync,b.return_message,b.push_status,b.academic_year_id,b.created_at, b.updated_at, a.amount, c.name as student_name, '" . $schema . "' as schema_name, (select sub_invoice from  " . $schema . ".setting limit 1) as sub_invoice   from  " . $schema . ".invoices b join " . $schema . ".student c on c.student_id=b.student_id join ( select sum(balance) as amount, a.invoice_id from " . $schema . ".invoice_balances a group by a.invoice_id ) a on a.invoice_id=b.id where  a.amount >0  and b.sync <>1 order by random() limit 15");

        foreach ($invoices as $invoice) {

            if ($invoice->sub_invoice == 1) {
                $sub_invoices = DB::select("select b.id,b.status, b.student_id, b.reference||'EA'||a.fee_id as reference, b.prefix,b.date,b.sync,b.return_message,b.push_status,b.academic_year_id,b.created_at, b.updated_at, a.balance as amount, c.name as student_name, '" . $schema . "' as schema_name from  " . $schema . ".invoices b join " . $schema . ".student c on c.student_id=b.student_id join " . $schema . ".invoice_balances a on a.invoice_id=b.id  where b.id=" . $invoice->id);

                foreach ($sub_invoices as $sub_invoice) {
                    $this->pushInvoice($sub_invoice);
                }
            } else {
                $this->pushInvoice($invoice);
            }
        }
    }

    public function deleteInvoice($invoice, $token) {
        if (strlen($token) > 4) {
            $fields = array(
                "reference" => trim($invoice->reference),
                "token" => $token
            );

            $push_status = 'invoice_cancel';
            //$push_status = 'invoice_submission';
            echo $push_status.$invoice->schema_name;
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
            if (isset($result) && !empty($result)) {
                //update invoice no
                DB::table($invoice->schema_name . '.invoices')
                        ->where('reference', $invoice->reference)->update(['sync' => 0, 'return_message' => $curl, 'push_status' => $push_status, 'updated_at' => 'now()']);
            }
            DB::table('api.requests')->insert(['return' => $curl, 'content' => json_encode($fields)]);
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
                "type" => ucfirst($invoice->schema_name) . '  School fee',
                "code" => "10",
                "callback_url" => "http://51.91.251.252:8081/api/init",
                "token" => $token
            );
            switch ($invoice->status) {
                case 2:

                    $this->updateInvoiceStatus($fields, $invoice, $token);
                    break;
                case 3:
                    $this->deleteInvoice($invoice, $token);

                    break;
                default:
                    $this->pushStudentInvoice($fields, $invoice, $token);
                    break;
            }
        }
    }

    public function pushStudentInvoice($fields, $invoice, $token) {
        $push_status = 'invoice_submission';
        //$push_status = 'invoice_submission';
        echo $push_status.$invoice->schema_name;
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
        // echo $result->description;
        //if (isset($result->description) && (strtolower($result->description) == 'success') || $result->description == 'Duplicate Invoice Number') {

        if (isset($result) && !empty($result)) {
            //update invoice no
            DB::table($invoice->schema_name . '.invoices')
                    ->where('reference', $invoice->reference)->update(['sync' => 1, 'return_message' => $curl, 'push_status' => $push_status, 'updated_at' => 'now()']);

            $users = DB::table($invoice->schema_name . '.parent')->whereIn('parentID', DB::table('student_parents')->where('student_id', $invoice->student_id)->get(['parent_id']))->get();
            foreach ($users as $user) {
                $message = 'Hello ' . $user->name . ','
                        . 'Control Namba ya ' . $invoice->student_name . ', kwa malipo ya ' . $invoice->schema_name . ' ni ' . $invoice->reference . '.'
                        . 'Unaweza lipa sasa kupitia mitandao ya simu au njia nyingine za bank ulizo elekezwa na shule. Asante';
                if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                    DB::statement("insert into " . $invoice->schema_name . ".email (email,subject,body) values ('" . $user->email . "', 'Control Number Ya Malipo ya Ada ya Shule','" . $message . "')");
                }
                DB::statement("insert into " . $invoice->schema_name . ".sms (phone_number,body,type) values ('" . $user->phone . "','" . $message . "',0)");
            }
        }
        DB::table('api.requests')->insert(['return' => $curl, 'content' => json_encode($fields)]);
    }

    public function updateInvoiceStatus($fields, $invoice, $token) {
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
        echo 'invoice update'.$invoice->schema_name;
        $curl = $this->curlServer($fields, $url);
        $result = json_decode($curl);

        if (isset($result) && !empty($result)) {
            //update invoice no
            DB::table($invoice->schema_name . '.invoices')
                    ->where('reference', $invoice->reference)->update(['sync' => 1, 'return_message' => $curl, 'push_status' => $push_status, 'updated_at' => 'now()']);

            $users = DB::table($invoice->schema_name . '.parent')->whereIn('parentID', DB::table('student_parents')->where('student_id', $invoice->student_id)->get(['parent_id']))->get();
            foreach ($users as $user) {
                $message = 'Hello ' . $user->name . ','
                        . 'Control Namba ya ' . $invoice->student_name . ', kwa malipo ya ' . $invoice->schema_name . ' imebadilishwa hivyo tumia control number: ' . $invoice->reference . '.'
                        . 'Unaweza lipa sasa kupitia mitandao ya simu au njia nyingine za bank ulizo elekezwa na shule. Asante';
                if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                    DB::statement("insert into " . $invoice->schema_name . ".email (email,subject,body) values ('" . $user->email . "', 'Control Number Mpya Ya Malipo ya Ada ya Shule','" . $message . "')");
                }
                DB::statement("insert into " . $invoice->schema_name . ".sms (phone_number,body,type) values ('" . $user->phone . "','" . $message . "',0)");
            }
        }
        DB::table('api.requests')->insert(['return' => $curl, 'content' => json_encode($fields)]);
    }

    public function updateInvoice() {
        return false;
        $invoices = DB::select('select * from api.invoices where sync=2 and amount >0 order by random() limit 10');
        if (!empty($invoices)) {
            foreach ($invoices as $invoice) {
                $token = $this->getToken($invoice);
                if (strlen($token) > 4) {
                    $fields = array(
                        "reference" => trim($invoice->reference),
                        "student_name" => $invoice->student_name,
                        "student_id" => $invoice->student_id,
                        "amount" => $invoice->amount,
                        //  "type" => $this->getFeeNames($invoice->id, $invoice->schema_name),
                        "type" => ucfirst($invoice->schema_name) . ' School Fees',
                        "code" => "10",
                        "callback_url" => "http://51.91.251.252:8081/api/init",
                        "token" => $token
                    );
                    $push_status = $invoice->status == 2 ? 'invoice_update' : 'invoice_submission';
                    // $push_status = 'invoice_update';
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
                                ->where('reference', $invoice->reference)->update(['sync' => 1, 'return_message' => $curl, 'push_status' => $push_status, 'updated_at' => 'now()']);
                    }
                    DB::table('api.requests')->insert(['return' => $curl, 'content' => json_encode($fields)]);
                }
            }
        }
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
            //  $setting = DB::table('beta_testing.setting')->first();
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
                $credentials = DB::table($invoice->schema_name . '.bank_accounts_integrations')->first();
                $user = trim($credentials->api_username);
                $pass = trim($credentials->api_password);
            }
        }
        $request = $this->curlServer([
            'username' => $user,
            'password' => $pass
                ], $url);
        $obj = json_decode($request);

        // print_r($obj);
        //DB::table('api.requests')->insert(['return' => json_encode($obj), 'content' => json_encode($request)]);
        if (isset($obj) && is_object($obj) && isset($obj->status) && $obj->status == 1) {
            return $obj->token;
        }
    }

    private function save_api_request($api_key = '', $api_secret = '') {
        $ip = $_SERVER['REMOTE_ADDR'];

        $host = gethostbyaddr($ip);

        $this->db->insert('pay', array(
            'key' => $api_key,
            'secret' => $api_secret,
            'content' => 'transaction ID=' . $this->input->get_post('transaction_id') . ' method=' . $this->input->get_post('method') . ' branch name=' . $this->input->get_post('branch_name'),
            'header' => 'REMOTE_ADDR=' . $this->input->get_post('REMOTE_ADDR') . ' REMOTE_PORT=' . $this->input->get_post('REMOTE_PORT'),
            'remote_ip' => $this->get_remote_ip(),
            'remote_hostname' => $host
        ));
//Force security measures
    }

    public function save_car_track_access_token($schema = '') {
        $sql = 'select  * from ' . $schema . '.car_tracker_key';
        $track_key = \collect(DB::select($sql))->first();
        if ($track_key) {
            $request = $this->JimiServer([
                'method' => 'jimi.oauth.token.get',
                'sign_method' => 'md5',
                'timestamp' => gmdate("Y-m-d H:i:s", time()),
                'user_id' => $track_key->user_id,
                'v' => '0.9',
                'expires_in' => 7200,
                'app_key' => $track_key->app_key,
                'user_pwd_md5' => $track_key->user_pwd_md5,
                'format' => 'json'], 'http://open.10000track.com/route/rest');


            $obj_content = json_decode($request, true);

            if ($obj_content['code'] == 0) {

                //dd($obj_content['result']['accessToken']);
                DB::table($schema . '.car_tracker_key')->where('id', '>', 0)->update(['access_token' => $obj_content['result']['accessToken']]);
            }
        }
        echo 'the table is empty';
    }

    public function car_track_alert_parent($schema = '') {

        $imeis = DB::select("select string_agg(imeis::text, ',') as imeis from " . $schema . ".vehicles");
        $key = DB::table('public.sms_keys')->first();
        $sql = 'select  * from ' . $schema . '.car_tracker_key';
        $track_key = \collect(DB::select($sql))->first();


        $request = $this->JimiServer([
            'method' => 'jimi.user.device.location.list',
            'sign_method' => 'md5',
            'timestamp' => gmdate("Y-m-d H:i:s", time()),
            'user_id' => $track_key->user_id,
            'v' => '0.9',
            'app_key' => $track_key->app_key,
            'user_pwd_md5' => $track_key->user_pwd_md5,
            'format' => 'json',
            'access_token' => $track_key->access_token,
            'map_type' => 'GOOGLE',
            'imeis' => $imeis[0]->imeis,
            'target' => 'shulesoft',
                ], 'http://open.10000track.com/route/rest');


        $obj_content = json_decode($request, true);

        if ($obj_content['code'] == 0) {
            //$devices=$obj_content['result'];

            foreach ($obj_content['result'] as $device) {
                $lat = $device['lat'];
                $lng = $device['lng'];
                $imeis = $device['imei'];


                $distance_sql = 'select * from (select parent_id, phone,name,imeis, 6371 * acos(cos(radians(' . $lat . '))
     * cos(radians(student_gps.lat)) 
     * cos(radians(student_gps.lng) - radians(' . $lng . ')) 
     + sin(radians(' . $lat . ')) 
     * sin(radians(student_gps.lat))) AS distance from ' . $schema . '.student_gps) as gps_query where imeis=\'' . $imeis . '\' and distance >0 and distance <=0.78 ';


                $near_by_students = DB::select($distance_sql);


                if (count($near_by_students) > 0) {
                    $table = "table";
                    foreach ($near_by_students as $near_by_student) {
                        DB::statement("insert into public.sms (phone_number,body,type,sms_keys_id,user_id,\"$table\") values ('" . $near_by_student->phone . "','" . $track_key->message . "',0," . $key->id . "," . $near_by_student->parent_id . ",'parent' )");
                    }
                }
            }
        }
    }

    public function JimiServer($fields, $url) {

        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/x-www-form-urlencoded'
        ));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 
     * @param type $fields
     */
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

    public function updateEmailConfig() {
        $find_sent_items = App\Email_sent::where('email_config_id', env('CONFIG_ID'))->get();
        if (count($find_sent_items) > 0 && count($find_sent_items) < 1000) {
//I found sent Items within a range
//update add by one
            $config = App\Email_config::find(env('CONFIG_ID'));
            if (count($config) > 0) {
                $ob = array(
                    'CONFIG_ID' => $config->id,
                    'email' => $config->email,
                    'MAIL_USERNAME' => $config->username,
                    'MAIL_PASSWORD' => $config->password,
                    'MAIL_HOST' => $config->host
                );
                foreach ($ob as $key => $value) {
                    $this->updateDotEnv($key, $newValue);
                }
            }
        } else if (count($find_sent_items) > 1000) {
            App\Email_config::where('status', '<>', 1)->update(['status' => 1]);
            $config = App\Email_config::where('status', 1)->first();
            if (count($config) > 0) {
                $ob = array(
                    'CONFIG_ID' => $config->id,
                    'email' => $config->email,
                    'MAIL_USERNAME' => $config->username,
                    'MAIL_PASSWORD' => $config->password,
                    'MAIL_HOST' => $config->host
                );
                foreach ($ob as $key => $value) {
                    $this->updateDotEnv($key, $newValue);
                }
            }
        }
    }

    protected function updateDotEnv($key, $newValue, $delim = '') {

        $path = base_path('.env');
// get old value from current env
        $oldValue = env($key);

// was there any change?
        if ($oldValue === $newValue) {
            return;
        }

// rewrite file content with changed data
        if (file_exists($path)) {
// replace current value with new value 
            file_put_contents(
                    $path, str_replace(
                            $key . '=' . $delim . $oldValue . $delim, $key . '=' . $delim . $newValue . $delim, file_get_contents($path)
                    )
            );
        }
    }

    public function sendTodReminder() {
        $users = DB::select('select * from admin.all_teacher_on_duty');
        $all_users = [];

        foreach ($users as $user) {
            unset($all_users[$user->name]);
            $students = DB::SELECT('SELECT name FROM ' . $user->schema_name . '.student where student_id in(select student_id from ' . $user->schema_name . '.student_duties where duty_id=' . $user->duty_id . ')');
            foreach ($students as $student) {
                array_push($all_students, $student->name);
            }
            $message = 'Habari  ' . $user->name . ' ,'
                    . 'Leo ' . date("Y-m-d") . ' umewekwa kama walimu wa zamu Shuleni pamoja na ' . implode(',', $all_students) . ' (Viranja)  . Kumbuka kuandika repoti yako ya siku katika account yako ya ShuleSoft kwa ajili ya kumbukumbu. Asante';

            if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                DB::statement("insert into " . $user->schema_name . ".email (email,subject,body) values ('" . $user->email . "', 'Ratiba Ya Zamu','" . $message . "')");
            }
            $key = DB::table($user->schema_name . '.sms_keys')->first();
            DB::statement("insert into " . $user->schema_name . ".sms (phone_number,body,type,sms_keys_id) values ('" . $user->phone . "','" . $message . "',0," . $key->id . ")");
        }
    }

    public function sendTaskReminder() {
        $users = DB::select('select a.activity,a.time,b.email,b.phone, b.name, c.name as client_name from admin.tasks a join admin.users b on a.user_id=b.id join admin.clients c on c.id=a.client_id where date::date=CURRENT_DATE and b.status=1');
        foreach ($users as $user) {
            $message = 'Hello  ' . $user->name . ' ,'
                    . 'Activity to do: ' . $user->activity . ' for ' . $user->client_name . '. Kindly remember to write all activities in respective profile.  Thanks';

            DB::statement("insert into public.email (email,subject,body) values ('" . $user->email . "', 'Todays Tasks','" . $message . "')");

            $key = DB::table('public.sms_keys')->first();
            DB::statement("insert into public.sms (phone_number,body,type,sms_keys_id) values ('" . $user->phone . "','" . $message . "',0," . $key->id . " )");
        }
    }

    public function getCleanSms($replacements, $message) {
        $patterns = array(
            '/#name/i', '/#username/i', '/#email/i', '/#phone/i', '/#usertype/i'
        );
        $sms = preg_replace($patterns, $replacements, $message);
        if (preg_match('/#/', $sms)) {
            //try to replace that character
            return preg_replace('/\#[a-zA-Z]+/i', '', $sms);
        } else {
            return $sms;
        }
    }

    public function sendSequenceReminder() {
        $sequences = \App\Models\Sequence::all();
        foreach ($sequences as $sequence) {
            $users = DB::select("select a.table, a.name,a.username,a.email,a.phone,a.usertype,a.schema_name,a.id,concat(c.firstname,' ',c.lastname ) as csr_name, c.phone as csr_phone from admin.all_users a,admin.users_schools b, admin.users c where b.schema_name=a.schema_name and b.user_id=c.id and a.status=1 and c.status=1 and b.role_id=8 and a.table not in ('parent','student','teacher') and a.id in (select user_id from admin.users_sequences a,admin.sequences
b where  (a.created_at::date + INTERVAL '" . $sequence->interval . " day')::date=CURRENT_DATE and b.interval=" . $sequence->interval . " )");
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $replacements = array(
                        $user->name, $user->username, $user->email, $user->phone, $user->usertype
                    );
                    $message = $this->getCleanSms($replacements, $sequence->message) . ''
                            . '. Kwa Msaada Nipigie: ' . $user->csr_name . ' (Account Manager - ' . $user->csr_phone . ')';
                    if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                        DB::table($user->schema_name . ".email")->insert([
                            'email' => $user->email,
                            'subject' => $sequence->title,
                            'body' => $message
                        ]);
                        //DB::statement("insert into " . $user->schema_name . ".email (email,subject,body) values ('" . $user->email . "', '" . $sequence->title . "','" . $message . "')");
                    }
                    $key = DB::table($user->schema_name . '.sms_keys')->first();
                    DB::table('public.sms')->insert([
                        'phone_number' => $user->phone,
                        'body' => $message,
                        'type' => 0,
                        'sms_keys_id' => $key->id
                    ]);
                    // DB::statement("insert into public.sms (phone_number,body,type) values ('" . $user->phone . "','" . $message . "',0)");
                    DB::table('users_sequences')->insert(['user_id' => $user->id, 'table' => $user->table, 'sequence_id' => $sequence->id, 'schema_name' => $user->schema_name
                    ]);
                }
            }
        }
    }

    public function sendNotice() {
        $notices = DB::select("select * from admin.all_notice  WHERE schema_name !='stpeterclaver' AND date-CURRENT_DATE=3 and status=0 ");
///these are notices
        foreach ($notices as $notice) {

//$class_ids = (explode(',', preg_replace('/{/', '', preg_replace('/}/', '', $notice->class_id))));
            $to_roll_ids = preg_replace('/{/', '', preg_replace('/}/', '', $notice->to_roll_id));

            $users = $to_roll_ids == 0 ? DB::select("select *,(select id as sms_keys_id from " . $notice->table_schema . ".sms_keys limit 1 ) as sms_keys_id from admin.all_users where 'table' not in ('student', 'setting') AND schema_name::text='" . $notice->schema_name . "'") : DB::select('select *,(select id as sms_keys_id from ' . $notice->schema_name . '.sms_keys limit 1 ) as sms_keys_id from admin.all_users where role_id IN (' . $to_roll_ids . ' ) and schema_name::text=\'' . $notice->schema_name . '\'  ');
            if (count($users) > 0) {
                foreach ($users as $user) {

                    $message = 'Kalenda ya Shule:'
                            . 'Siku ya tukio : ' . $notice->date . ' ,'
                            . 'Jina la Tukio:  ' . $notice->notice . ','
                            . 'Kwa taarifa zaidi, tembelea akaunti yako ya ShuleSoft. Asante';

                    if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                        DB::statement("insert into " . $notice->schema_name . ".email (email,subject,body) values ('" . $user->email . "', 'Calender Reminder : " . $notice->title . "','" . $message . "')");
                    }
                    DB::statement("insert into " . $notice->schema_name . ".sms (phone_number,body,type,sms_keys_id) values ('" . $user->phone . "','" . $message . "',0," . $user->sms_keys_id . " )");
                }
            }
        }
    }

    public function sendBirthdayWish() {
        $schemas = (new \App\Http\Controllers\Software())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin'))) {
                //Remind parents,class and section teachers to wish their students

                $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "select 'Hello '|| c.name|| ', tunapenda kumtakia '||a.name||' heri ya siku yake ya kuzaliwa katika tarehe kama ya leo. Mungu ampe afya tele, maisha marefu, baraka na mafanikio.  Kama hajaziliwa tarehe kama ya leo, tuambie tubadili tarehe zake ziwe sahihi. Ubarikiwe',c.phone, 0,0, c.\"parentID\",'parent', (select id from " . $schema->table_schema . ".sms_keys limit 1)  FROM " . $schema->table_schema . ".student a join " . $schema->table_schema . ".student_parents b on b.student_id=a.\"student_id\" JOIN " . $schema->table_schema . ".parent c on c.\"parentID\"=b.parent_id WHERE 
                    DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) AND a.status = 1  

                    AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE)";
                DB::statement($sql);

                //get students with birthday, with their section teacher names
                //get count total number of students with birthday today and send to admin
                $sql_for_teachers = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "SELECT 'Hello '||teacher_name||', leo ni birthday ya '||string_agg(student_name, ', ')||', katika darasa lako '||classes||'('||section||'). Usisite kumtakia heri ya kuzaliwa. Asante', phone,0,0,\"teacherID\",'teacher',(select id from " . $schema->table_schema . ".sms_keys limit 1 ) from ( select a.name as student_name, t.name as teacher_name, t.\"teacherID\", t.phone, c.section, d.classes from " . $schema->table_schema . ".student a join " . $schema->table_schema . ".section c on c.\"sectionID\"=a.\"sectionID\" JOIN " . $schema->table_schema . ".teacher t on t.\"teacherID\"=c.\"teacherID\" join " . $schema->table_schema . ".classes d on d.\"classesID\"=c.\"classesID\" WHERE  a.status=1 and  DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE)   AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE) ) x GROUP  BY teacher_name,phone,classes,section,phone,\"teacherID\"";
                DB::statement($sql_for_teachers);

                //send notification to administrators
                $sql_to_admin = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")"
                        . "select 'Hello '||s.sname||', leo ni birthday ya '||(select string_agg(a.name, ',') from " . $schema->table_schema . ".student a WHERE   DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) 
                    AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE))||' katika shule yako. Ingia katika account yako ya ShuleSoft kujua zaidi na uwatakie heri ya kuzaliwa. Asante', s.phone,0,0,1,'setting' from " . $schema->table_schema . ".student a join " . $schema->table_schema . ".setting s on true  group by s.sname,s.phone";
                // DB::statement($sql_to_admin);
            }
        }
    }

    public function sendReportReminder() {
        $schemas = (new \App\Http\Controllers\Software())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin', 'kisaraweljs', 'laureatemikocheni', 'laureatembezi', 'lifewaylighschools', 'montessori', 'sullivanprovost', 'ubungomodern', 'whiteangles', 'atlasschools'))) {
//parents
                $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', matokeo yote ya '||c.name||'  hupatikana kwenye ShuleSoft. Ili kuyaona, fungua https://" . $schema->table_schema . ".shulesoft.com, kisha nenda upande wa kushoto (sehemu imendikwa Exam Report (au Alama)) Kisha utaona matokeo yote. Kama umesahau neno siri lako ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then '123456' else p.default_password end||'.  Asante', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p join " . $schema->table_schema . ".student_parents sp on sp.parent_id=p.\"parentID\" JOIN " . $schema->table_schema . ".student c on c.\"student_id\"=sp.student_id, " . $schema->table_schema . ".setting s where p.status=1";
                //  DB::statement($sql);
            }
        }
    }

    public function sendLoginReminder() {
        $schemas = (new \App\Http\Controllers\Software())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin'))) {
                // $this->parentsExamLoginReminder($schema);
                //$this->sendGeneralReminder($schema);
                //$this->sendTeachersLoginReminder($schema);
                // $this->usersLoginReminder($schema); 
            }
        }
    }

    public function sendGeneralReminder($schema) {
        //parents
        $sql_updated = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Habari '|| p.name|| ',ungana nasi siku ya jumatano (11/07/2018), TBC-1 kwanzia saa 1 kamili usiku tutawafundisha wazazi wote jinsi ya kutumia 
ShuleSoft vizuri kupata ripoti mbalimbali kutoka shuleni. Usikose kushiriki nasi ujifunze zaidi. Karibu', p.phone, 0,0, p.id,\"table\" FROM " . $schema->table_schema . ".users p where p.phone is not null and \"table\" in ('parent','teacher','user') ";


        //return DB::statement($sql_updated);
    }

    public function parentGeneralLoginReminder($schema) {

        $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', ili uweze kuingia katika program ya ShuleSoft, nenda sehemu ya internet (Google), kisha andika https://" . $schema->table_schema . ".shulesoft.com, kisha ingiza nenotumizi (username) ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then '123456' else p.default_password end||'. Matokeo yote ya mwanao na taarifa za shule utazipata ShuleSoft. Kwa msaada, piga (0655406004) au uongozi wa shule ('||s.phone||'). Asante', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p, " . $schema->table_schema . ".setting s where p.\"parentID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"user\"='Parent') and p.status=1";
        return DB::statement($sql);
    }

    public function parentsExamLoginReminder($schema) {

        $sql_updated = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', ili kuona matokeo ya  mtoto wako katika ShuleSoft. Fungua  https://" . $schema->table_schema . ".shulesoft.com, kisha ingiza username ambayo ni '||p.username||' na password ya kuanzia ni '||p.default_password||'. Kwa msaada zaidi tupigie. Asante', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p, " . $schema->table_schema . ".setting s where p.\"parentID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"user\"='Parent') and p.status=1 and p.\"parentID\" IN (
SELECT a.parent_id from " . $schema->table_schema . ".student_parents a join " . $schema->table_schema . ".student b on b.student_id=a.student_id   where b.status=1 and a.student_id in (
select \"student_id\" from " . $schema->table_schema . ".student_exams ) )";
        return DB::statement($sql_updated);
    }

    public function usersLoginReminder($schema) {
        $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', je umewahi ingia katika akaunti yako ya ShuleSoft '||upper(s.sname)||'  na kujifunza jinsi inavyoweza kusaidia utendaji kazi wako uwe rahisi na kuboresha taaluma ya Shule ? Kama bado, ni rahis kuanza, kupitia simu yako au computer yako, ingia sehemu ya internet (Google), na kuandika https://" . $schema->table_schema . ".shulesoft.com, kisha ingiza nenotumizi (username) ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then 'user123' else p.default_password end||'. Kwa msaada(0655406004) au uongozi wa shule ('||s.phone||'). Siku njema', p.phone, 0,0, p.\"userID\",'user' FROM " . $schema->table_schema . ".user p, " . $schema->table_schema . ".setting s where p.\"userID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"user\" not in ('Teacher','Parent','Student')) and p.status=1";
        return DB::statement($sql);
    }

    public function sendTeachersLoginReminder($schema) {
        $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', kwa sasa, wastani wa kila mtihani uliosahihisha, mishahara ya kila mwezi (payroll na payslip), na taarifa zote za shule '||upper(s.sname)||'  utazipata katika akaunti yako ya ShuleSoft. Ili Kuingia, fungua sehemu ya internet (Google), na andika https://" . $schema->table_schema . ".shulesoft.com, kisha ingiza nenotumizi (username) lako '||p.username||' na nenosiri(password) lako ni '||case when p.default_password is null then 'teacher123' else p.default_password end||'. Kwa msaada(0655406004) au uongozi wa shule ('||s.phone||'). Karibu', p.phone, 0,0, p.\"teacherID\",'teacher' FROM " . $schema->table_schema . ".teacher p, " . $schema->table_schema . ".setting s where p.\"teacherID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"table\"='teacher') and p.status=1";
        // return DB::statement($sql);
    }

    public function sendSchedulatedSms() {
        
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path('routes/console.php');
    }

    private function addAttendance() {
        $date = date("Y-m-d");
        $datas = DB::connection('biotime')->table('public.iclock_transaction')->whereDate('punch_time', $date)->where('punch_state', '0')->get();
        if (count($datas) > 0) {
            foreach ($datas as $data) {

                // $employee = DB::table('public.personnel_employee')->where('id', $data->emp_id)->first();
                // if(!empty($employee)){
                $user = DB::table('admin.all_users')->where('sid', $data->emp_code)->first();
                $device = DB::table('api.attendance_devices')->where('serial_number', $data->terminal_sn)->first();

                if (!empty($user)) {
                    if (empty($device)) {
                        $device_id = DB::table('api.attendance_devices')->insert(['serial_number' => $data->terminal_sn, 'schema_name' => $user->schema_name]);
                        $device = DB::table('api.attendance_devices')->where('id', $device_id)->first();
                    }
                    if ($user->table == 'student') {
                        $attendance = DB::table($user->schema_name . '.sattendances')->where('student_id', $user->id)->whereDate('date', date('Y-m-d'))->first();
                        if (empty($attendance)) {
                            DB::table($user->schema_name . '.sattendances')->insert([
                                'student_id' => $user->id,
                                'created_by' => $device->id,
                                'created_by_table' => 'api',
                                'present' => 1,
                                'date' => date("Y-m-d", strtotime($data->punch_time))
                            ]);
                        }
                    } else {
                        $uattendance = DB::table($user->schema_name . '.uattendances')->where('user_id', $user->id)->where('user_table', $user->table)->whereDate('date', date('Y-m-d'))->first();
                        if (empty($uattendance)) {
                            DB::table($user->schema_name . '.uattendances')->insert([
                                'user_id' => $user->id,
                                'user_table' => $user->table,
                                'created_by' => $device->id,
                                'created_by_table' => 'api',
                                'timein' => 'now()',
                                'date' => date("Y-m-d", strtotime($data->punch_time)),
                                'present' => 1
                            ]);
                        }
                    }
                    DB::connection('biotime')->table('public.iclock_transaction')->where('id', $data->id)->update(['punch_state' => '1']);
                }
            }
        }
    }

private function client($client_id = null){
    return \App\Models\Client::where('id',$client_id)->first()->name;
}

//Send email remainder to accountant, ie role_id 13 = Financial accountant
public function sendSORemainder() {
  $users = \App\Models\User::where('role_id',13)->get();
  foreach ($users as $user) {
      $standingorders = DB::select('select * from admin.standing_orders WHERE payment_date-CURRENT_DATE = 1 AND is_approved =1');

      $msg = '';
      foreach ($standingorders as $standing) {
          $msg .= '<tr><td>' . $this->client($standing->client_id) . '</td><td>' . $standing->occurance_amount . '</td></tr>';
      }
      $message = ''
              . '<h2>Standing orders</h2>'
              . '<p>This is the list of matured standing orders </p>'
              . '<table><thead><tr><th>Client name</th><th> Amount </th></tr></thead><tbody>' . $msg . '</tbody></table>';
      DB::table('public.email')->insert([
          'subject' => date('Y M d') . ' Standing order remainder',
          'body' => $message,
          'email' => $user->email
      ]);

      $sms = 'Hello kindly remember to check matured standing orders in the admin panel. Thank you';
      DB::table('public.sms')->insert([
          'body' => $sms,
          'phone_number' => $user->phone,
          'type' => 0,
          'status' => 0
      ]);
  }
}

    public function endDeadlock() {

        DB::SELECT("WITH inactive_connections AS (SELECT pid, rank() over (partition by client_addr order by backend_start ASC) as rank
        FROM pg_stat_activity WHERE pid <> pg_backend_pid( ) AND application_name !~ '(?:psql)|(?:pgAdmin.+)' AND datname = current_database() AND usename = current_user 
        AND state in ('idle', 'idle in transaction', 'idle in transaction (aborted)', 'disabled') AND current_timestamp - state_change > interval '1 minutes') SELECT pg_terminate_backend(pid) FROM inactive_connections WHERE rank > 1");
        return DB::select("SELECT pg_terminate_backend(pid) from pg_stat_activity where state='idle' and query like '%DEALLOCATE%'");
    }

}
