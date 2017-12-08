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
                    $result = (object) json_decode($karibusms->send_sms($sms->phone_number, $sms->body));
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
                    $this->updateEmailConfig();
                }
            }
        })->everyMinute();


        $schedule->call(function () {
            // remind parents to login in shulesoft and check their child performance
            $this->sendNotice();
        })->dailyAt('08:00');

        $schedule->call(function(){
            //send login reminder to parents in all schema
            $this->sendLoginReminder();
        })->fridays()->at('13:00');
        
        $schedule->call(function () {
            // send Birdthday 
            $this->sendBirthdayWish();
        })->dailyAt('10:00');
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
                    DB::statement("insert into " . $notice->schema_name . ".sms (phone_number,body) values ('" . $user->phone . "','" . $message . "')");
                }
            }
        }
    }

    public function sendBirthdayWish() {
        
    }

    public function sendLoginReminder() {
        $schemas = (new \App\Http\Controllers\DatabaseController())->loadSchema();
        foreach ($schemas as $schema) {
            $sql = "insert into ".$schema->table_schema.".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', kuingia kwenye programu ya ShuleSoft '||upper(s.sname)||'  na kufuatilia taaluma ya mtoto wako   na taarifa mbali mbali za shule ni rahisi, kama hujawahi, tunakukumbusha unaweza ingia kupitia simu yako au computer yako kwa kuingia sehemu ya internet (Google), na kuandika https://".$schema->table_schema.".shulesoft.com, kisha ingiza nenotumizi (username) ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then '123456' else p.default_password end||'. Kumbuka ShuleSoft sasa inapikana kwa kiswahili pia. Kwa maswali, maoni au lolote, usisite kuwasiliana nasi (0655406004) au uongozi wa shule ('||s.phone||'). Siku njema', p.phone, 0,0, p.\"parentID\",'parent' FROM ".$schema->table_schema.".parent p, ".$schema->table_schema.".setting s where p.\"parentID\" NOT IN (SELECT user_id from ".$schema->table_schema.".log where user_id is not null and \"user\"='Parent') and p.status=1";
            DB::statement($sql);
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
