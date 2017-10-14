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
        })->weekly()->mondays()->at('13:00');
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
        $notices = DB::select('select * from ' . set_schema_name() . "notice  WHERE  date-CURRENT_DATE=3 and status=0 ");
        ///these are notices
        foreach ($notices as $notice) {

            //$class_ids = (explode(',', preg_replace('/{/', '', preg_replace('/}/', '', $notice->class_id))));
            $to_roll_ids = implode(',', preg_replace('/{/', '', preg_replace('/}/', '', $notice->to_roll_id)));

            $users = DB::select('select * from admin.all_users where role_id IN (' . $to_roll_ids . ' ) ');
            if (count($users) > 0) {
                foreach ($users as $user) {
                   
                    $message = 'Event Reminder:'
                                . 'Date : '.$notice->date.' ' . $user->name . ', ';
                    $this->send_email($user->email, 'Calender Reminder', $message);
                }
            }
        }
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
