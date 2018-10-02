<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
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
            //get all connected phones first
            $phones_connected = DB::select('select distinct api_key from public.all_sms');
            if (count($phones_connected) > 0) {
                foreach ($phones_connected as $phone) {
                    $messages = DB::select('select * from public.all_sms where api_key=\'' . $phone->api_key . '\' order by priority desc, sms_id asc limit 8');
                    if (!empty($messages)) {
                        foreach ($messages as $sms) {
                            $schema = strtoupper($sms->schema_name) == 'PUBLIC' ?
                                    'SHULESOFT' : $sms->schema_name;
                            $link = strtoupper($sms->schema_name) == 'PUBLIC' ? '' : $sms->schema_name . '.';
                            $karibusms = new \karibusms();
                            $karibusms->API_KEY = $sms->api_key;
                            $karibusms->API_SECRET = $sms->api_secret;
                            $karibusms->set_name(strtoupper($sms->schema_name));
                            $karibusms->karibuSMSpro = $sms->type;
                            $result = (object) json_decode($karibusms->send_sms($sms->phone_number, strtoupper($schema) . ': ' . $sms->body . '. https://' . $link . 'shulesoft.com'));
                            if ($result->success == 1) {
                                DB::table($sms->schema_name . '.sms')->where('sms_id', $sms->sms_id)->update(['status' => 1, 'return_code' => json_encode($result), 'updated_at' => 'now()']);
                            } else {
//stop retrying
                                DB::table($sms->schema_name . '.sms')->where('sms_id', $sms->sms_id)->update(['status' => 1, 'return_code' => json_encode($result), 'updated_at' => 'now()']);
                            }
                        }
                    }
                }
            }
        })->everyMinute();

        $schedule->call(function () {
//loop through schema names and push emails
            $this->emails = DB::select('select * from public.all_email limit 8');
            if (!empty($this->emails)) {
                foreach ($this->emails as $message) {
                    if (filter_var($message->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $message->email)) {
                        try {
                            $data = ['content' => $message->body, 'link' => $message->schema_name, 'photo' => $message->photo, 'sitename' => $message->sitename, 'name' => ''];
                            \Mail::send('email.default', $data, function ($m) use ($message) {
                                $m->from('noreply@shulesoft.com', $message->sitename);
                                $m->to($message->email)->subject($message->subject);
                            });
                            if (count(\Mail::failures()) > 0) {
                                DB::update('update ' . $message->schema_name . '.email set status=0 WHERE email_id=' . $message->email_id);
                            } else {
                                if ($message->email == 'inetscompany@gmail.com') {
                                    DB::table($message->schema_name . '.email')->where('email_id', $message->email_id)->delete();
                                } else {
                                    DB::update('update ' . $message->schema_name . '.email set status=1 WHERE email_id=' . $message->email_id);
                                }
                            }
                        } catch (\Exception $e) {
                            // error occur
                            //DB::table('public.sms')->insert(['body'=>'email error'.$e->getMessage(),'status'=>0,'phone_number'=>'0655406004','type'=>0]);
                            echo 'something is not write' . $e->getMessage();
                        }
                    } else {
//skip all emails with ShuleSoft title
//skip all invalid emails
                        DB::update('update ' . $message->schema_name . '.email set status=1 WHERE email_id=' . $message->email_id);
                    }
//$this->updateEmailConfig();
                    sleep(5);
                }
            }
        })->everyMinute();


        $schedule->call(function () {
// remind parents to login in shulesoft and check their child performance
            // $this->sendNotice();
            $this->sendBirthdayWish();
        })->dailyAt('04:40'); // Eq to 07:40 AM 

        $schedule->call(function() {
//send login reminder to parents in all schema
            $this->sendLoginReminder();
        })->fridays()->at('9:00');

        $schedule->call(function() {
//send login reminder to parents in all schema
            //$this->notifyUsersDailyReports();
        })->weekly()->weekdays()->at('13:00');

        $schedule->call(function () {
// send Birdthday 
            // $this->sendReportReminder();
        })->dailyAt('07:00');

        $schedule->call(function () {
// sync invoices 
            $this->syncInvoice();
        })->everyMinute();
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
        if (count($fees) > 0) {
            foreach ($fees as $fee) {

                array_push($names, $fee->name);
            }
        }
        $uq_names = array_unique($names);
        return implode(',', $uq_names);
    }

    public function syncInvoice() {
        $invoices = DB::select('select * from api.invoices where sync=0 and amount >0 order by random() limit 15');
        if (count($invoices) > 0) {
            foreach ($invoices as $invoice) {
                $token = $this->getToken($invoice);
                $fields=[];
                if (strlen($token) > 4) {
                    $fields = array(
                        "reference" => trim($invoice->reference),
                        "student_name" => $invoice->student_name,
                        "student_id" => $invoice->student_id,
                        "amount" => $invoice->amount,
                        "type" => $this->getFeeNames($invoice->id, $invoice->schema_name),
                        "code" => "10",
                        "callback_url" => "http://158.69.112.216:8081/api/init",
                        "token" => $token
                    );
                    // $push_status = $invoice->status == 2 ? 'invoice_update' : 'invoice_submission';
                    $push_status = 'invoice_submission';
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
                }
                DB::table('api.requests')->insert(['return' => $curl, 'content' => json_encode($fields),'token'=>$token]);
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
            $setting = DB::table('beta_testing.setting')->first();
            $url = 'https://wip.mpayafrica.com/v2/auth';
        } else {
            //live invoice
            $setting = DB::table($invoice->schema_name . '.setting')->first();
            $url = 'https://api.mpayafrica.co.tz/v2/auth';
        }
        if ($setting->payment_integrated == 1) {
            $user = trim($setting->api_username);
            $pass = trim($setting->api_password);
            $request = $this->curlServer([
                'username' => $user,
                'password' => $pass
                    ], $url);
            $obj = json_decode($request);
            if (isset($obj) && is_object($obj) && isset($obj->status) && $obj->status == 1) {
                return $obj->token;
            }
        } else {
            return false;
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

                    $message = 'Kalenda ya Shule:'
                            . 'Siku ya tukio : ' . $notice->date . ' ,'
                            . 'Jina la Tukio:  ' . $notice->notice . ','
                            . 'Kwa taarifa zaidi, tembelea akaunti yako ya ShuleSoft. Asante';

                    if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                        DB::statement("insert into " . $notice->schema_name . ".email (email,subject,body) values ('" . $user->email . "', 'Calender Reminder : " . $notice->title . "','" . $message . "')");
                    }
                    DB::statement("insert into " . $notice->schema_name . ".sms (phone_number,body,type) values ('" . $user->phone . "','" . $message . "',0)");
                }
            }
        }
    }

    public function sendBirthdayWish() {
        $schemas = (new \App\Http\Controllers\DatabaseController())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin'))) {
                //Remind parents,class and section teachers to wish their students
                $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")"
                        . "select 'Hello '|| c.name|| ', tunapenda kumtakia '||a.name||' heri ya siku yake ya kuzaliwa katika tarehe kama ya leo. Mungu ampe afya tele, maisha marefu, baraka na mafanikio.  Kama hajaziliwa tarehe kama ya leo, tuambie tubadili tarehe zake ziwe sahihi. Ubarikiwe',c.phone, 0,0, c.\"parentID\",'parent'  FROM " . $schema->table_schema . ".student a join " . $schema->table_schema . ".student_parents b on b.student_id=a.\"student_id\" JOIN " . $schema->table_schema . ".parent c on c.\"parentID\"=b.parent_id WHERE 
                    DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) 
                    AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE)";
                DB::statement($sql);

                //get students with birthday, with their section teacher names
                //get count total number of students with birthday today and send to admin
                $sql_for_teachers = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")"
                        . "SELECT 'Hello '||teacher_name||', leo ni birthday ya '||string_agg(student_name, ', ')||', katika darasa lako '||classes||'('||section||'). Usisite kumtakia heri ya kuzaliwa. Asante', phone,0,0,\"teacherID\",'teacher' from ( select a.name as student_name, t.name as teacher_name, t.\"teacherID\", t.phone, c.section, d.classes from " . $schema->table_schema . ".student a join " . $schema->table_schema . ".section c on c.\"sectionID\"=a.\"sectionID\" JOIN " . $schema->table_schema . ".teacher t on t.\"teacherID\"=c.\"teacherID\" join " . $schema->table_schema . ".classes d on d.\"classesID\"=c.\"classesID\" WHERE  a.status=1 and  DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE)   AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE) ) x GROUP  BY teacher_name,phone,classes,section,phone,\"teacherID\"";
                DB::statement($sql_for_teachers);

                //send notification to administrators
//                $sql_to_admin="insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")"
//                        ."select 'Hello '||s.sname||', leo ni birthday ya wanafunzi '||count(*)||' katika shule lako. Unaweza ingia katika account yako ya shule ili uwajue na uwatakie heri ya kuzaliwa. Asante', s.phone,0,0,1,'setting' from testing.student a join testing.setting s on true WHERE   DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) 
//                    AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE) group by s.sname,s.phone";
//                DB::statement($sql_to_admin);
            }
        }
    }

    public function sendReportReminder() {
        $schemas = (new \App\Http\Controllers\DatabaseController())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin', 'kisaraweljs', 'laureatemikocheni', 'laureatembezi', 'lifewaylighschools', 'montessori', 'sullivanprovost', 'ubungomodern', 'whiteangles', 'atlasschools'))) {
//parents
                $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', matokeo yote ya '||c.name||'  hupatikana kwenye ShuleSoft. Ili kuyaona, fungua https://" . $schema->table_schema . ".shulesoft.com, kisha nenda upande wa kushoto (sehemu imendikwa Exam Report (au Alama)) Kisha utaona matokeo yote. Kama umesahau neno siri lako ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then '123456' else p.default_password end||'.  Asante', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p join " . $schema->table_schema . ".student_parents sp on sp.parent_id=p.\"parentID\" JOIN " . $schema->table_schema . ".student c on c.\"student_id\"=sp.student_id, " . $schema->table_schema . ".setting s where p.status=1";
                DB::statement($sql);
            }
        }
    }

    public function sendLoginReminder() {
        $schemas = (new \App\Http\Controllers\DatabaseController())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin'))) {
                // $this->parentsExamLoginReminder($schema);
                $this->sendGeneralReminder($schema);
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
select 'Hello '|| p.name|| ', ili kuona matokeo ya mtoto wako katika ShuleSoft. Fungua hii link  https://" . $schema->table_schema . ".shulesoft.com, kisha ingiza nenotumizi (username) ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then '123456' else p.default_password end||'. Kwa msaada wa kuingia, tupigie. Asante', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p, " . $schema->table_schema . ".setting s where p.\"parentID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"user\"='Parent') and p.status=1 and p.\"parentID\" IN (
SELECT parent_id from " . $schema->table_schema . ".student_parents where student_id in (
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

}
