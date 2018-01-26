<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
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
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            //check if there is any sms then send
            //check if there is any email then send
            //$this->testCrone();

            $messages = DB::select('select * from public.all_sms limit 20');
            if (!empty($messages)) {
                foreach ($messages as $sms) {

                    $karibusms = new \karibusms();
                    $karibusms->API_KEY = $sms->api_key;
                    $karibusms->API_SECRET = $sms->api_secret;
                    $karibusms->set_name(strtoupper($sms->schema_name));
                    $karibusms->karibuSMSpro = $sms->type;
                    $result = (object) json_decode($karibusms->send_sms($sms->phone_number, strtoupper($sms->schema_name) . ': ' . $sms->body . '. https://' . $sms->schema_name . '.shulesoft.com'));
                    if ($result->success == 1) {
                        DB::update('update ' . $sms->schema_name . '.sms set status=1 WHERE sms_id=' . $sms->sms_id);
                    } else {
                        DB::update('update ' . $sms->schema_name . '.sms set status=0 WHERE sms_id=' . $sms->sms_id);
                    }
                }
            }
        })->everyMinute();

        $schedule->call(function () {
            //loop through schema names and push emails
            $this->emails = DB::select('select * from public.all_email limit 30');
            if (!empty($this->emails)) {
                foreach ($this->emails as $message) {
                    if (filter_var($message->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $message->email)) {
                        $data = ['content' => $message->body, 'link' => $message->schema_name, 'photo' => $message->photo, 'sitename' => $message->sitename, 'name' => ''];
                        Mail::send('email.default', $data, function ($m) use ($message) {
                            $m->from('no-reply@shulesoft.com', $message->sitename);
                            $m->to($message->email)->subject($message->subject);
                        });
                        if (count(Mail::failures()) > 0) {
                            DB::update('update ' . $message->schema_name . '.email set status=0 WHERE email_id=' . $message->email_id);
                        } else {
                            DB::update('update ' . $message->schema_name . '.email set status=1 WHERE email_id=' . $message->email_id);
                        }
                    } else {
                        //skip all emails with ShuleSoft title
                        //skip all invalid emails
                        DB::update('update ' . $message->schema_name . '.email set status=1 WHERE email_id=' . $message->email_id);
                    }
                    //$this->updateEmailConfig();
                }
            }
        })->everyMinute();


        $schedule->call(function () {
            // remind parents to login in shulesoft and check their child performance
            $this->sendNotice();
        })->dailyAt('08:00');

        $schedule->call(function() {
            //send login reminder to parents in all schema
            $this->sendLoginReminder();
        })->fridays()->at('13:00');

        $schedule->call(function () {
            // send Birdthday 
            $this->sendBirthdayWish();
        })->dailyAt('10:00');

        $schedule->call(function () {
            // sync invoices 
            $this->syncInvoice();
        })->everyMinute();
    }

    function getFeeNames($invoice_id, $schema_name) {
        $fees = DB::select('select c.name from ' . $schema_name . '.invoice_fee a join ' . $schema_name . '.fee_installment b on b.id=a.fee_installment_id join ' . $schema_name . '.fee c on c.id=b.fee_id where a.invoices_id=' . $invoice_id);
        $names = array();
        if (count($fees) > 0) {
            foreach ($fees as $fee) {

                array_push($names, $fee->name);
            }
        }
        $uq_names = array_unique($names);
        return implode(',', $uq_names);
    }

    public function syncInvoice() {
        $invoices = DB::select('select * from admin.api_invoices where sync=0 order by random() limit 10');
        if (count($invoices) > 0) {
            foreach ($invoices as $invoice) {
                $token = $this->getToken($invoice->schema_name);
                if (strlen($token) > 4) {
                    $fields = array(
                        "reference" => $invoice->invoiceNO,
                        "student_name" => $invoice->student_name,
                        "student_id" => $invoice->studentID,
                        "amount" => $invoice->amount,
                        "type" => $this->getFeeNames($invoice->id, $invoice->schema_name),
                        "code" => "10",
                        "callback_url" => "http://158.69.112.216:8081/api/init",
                        "token" => $token
                    );
                    $curl = $this->curlServer($fields, 'https://api.mpayafrica.co.tz/v2/invoice_submission');
                    $result = json_decode($curl);
                    if (($result->status == 1 && strtolower($result->description) == 'success') || $result->description == 'Duplicate Invoice Number') {
                        //update invoice no
                        DB::table($invoice->schema_name . '.invoices')
                                ->where('invoiceNO', $invoice->invoiceNO)->update(['sync' => 1]);
                    } else {
                        DB::table('api.requests')->insert(['content' => $curl.', request='. json_encode($fields)]);
                    }
                }
            }
        }
    }

    /**
     * 
     * @param type $schema
     * @return type
     * 
      Username: 109M17SA01DINET
      Password : LuHa6bAjKV5g5vyaRaRZJy*x5@%!yBBBTVy  , mother of mercy
     */
    public function getToken($schema) {
        $setting = DB::table($schema . '.setting')->first();
        $request = $this->curlServer([
            'username' => $setting->api_username,
            'password' => $setting->api_password
                ], 'https://api.mpayafrica.co.tz/v2/auth');
        $obj = json_decode($request);
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

    public function sendNotice() {
        $notices = DB::select('select * from admin.all_notice  WHERE  date-CURRENT_DATE=3 and status=0 ');
        ///these are notices
        foreach ($notices as $notice) {

            //$class_ids = (explode(',', preg_replace('/{/', '', preg_replace('/}/', '', $notice->class_id))));
            $to_roll_ids = preg_replace('/{/', '', preg_replace('/}/', '', $notice->to_roll_id));

            $users = $to_roll_ids == 0 ? DB::select("select * from admin.all_users where schema_name::text='" . $notice->schema_name . "'") : DB::select('select * from admin.all_users where role_id IN (' . $to_roll_ids . ' ) and schema_name::text=\'' . $notice->schema_name . '\'  ');
            if (count($users) > 0) {
                foreach ($users as $user) {

                    $message = 'Automatic Event Reminder:'
                            . 'Event Date : ' . $notice->date . ' ,'
                            . 'Event Name:  ' . $notice->notice . ','
                            . 'For More information, please login https://' . $notice->schema_name . '.shulesoft.com';

                    if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                        DB::statement("insert into " . $notice->schema_name . ".email (email,subject,body) values ('" . $user->email . "', 'Calender Reminder : " . $notice->title . "','" . $message . "')");
                    }
                    DB::statement("insert into " . $notice->schema_name . ".sms (phone_number,body,type) values ('" . $user->phone . "','" . $message . "',0)");
                }
            }
        }
    }

    public function sendBirthdayWish() {
        
    }

    public function sendLoginReminder() {
        $schemas = (new \App\Http\Controllers\DatabaseController())->loadSchema();
        foreach ($schemas as $schema) {
            if ($schema->table_schema != 'public') {
                $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', kuingia kwenye programu ya ShuleSoft '||upper(s.sname)||'  na kufuatilia taaluma ya mtoto wako   na taarifa mbali mbali za shule ni rahisi, kama hujawahi, tunakukumbusha unaweza ingia kupitia simu yako au computer yako kwa kuingia sehemu ya internet (Google), na kuandika https://" . $schema->table_schema . ".shulesoft.com, kisha ingiza nenotumizi (username) ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then '123456' else p.default_password end||'. Kumbuka ShuleSoft sasa inapikana kwa kiswahili pia. Kwa maswali, maoni au lolote, usisite kuwasiliana nasi (0655406004) au uongozi wa shule ('||s.phone||'). Siku njema', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p, " . $schema->table_schema . ".setting s where p.\"parentID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"user\"='Parent') and p.status=1";
                DB::statement($sql);
            }
        }
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

    public function send($param) {
        
    }

}
