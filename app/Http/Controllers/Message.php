<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class Message extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (request('message') != '') {
            $script = $this->pushSMS();
            $message_success = 'Message sent ';
        } else {
            $script = '';
            $message_success = '';
        }
        $usertypes = DB::select('select distinct usertype from admin.all_users');
        return view('message.create', compact('script', 'usertypes', 'message_success'));
    }

    public function pushSMS($slave_schema = null) {
        $skip = request('skip');
        $database = new DatabaseController();
        $skip_schema = preg_match('/,/', $skip) ? explode(',', $skip) : array($skip);
        $db_schema = $database->loadSchema();
        $schemas = $slave_schema == null ? $db_schema : array($slave_schema);
        $q = '';
        $sch = '';

        foreach ($schemas as $key => $value) {
            $sch .= in_array($value->table_schema, $skip_schema) ? '' : "'" . $value->table_schema . "',";
        }
        $list_schema = rtrim($sch, ',');
        $message = request('message');

        $usr = request('usertype');
        $usr_type = '';
        if (count($usr) > 0) {
            foreach ($usr as $val) {
                $usr_type .= "'" . $val . "',";
            }
            $type = rtrim($usr_type, ',');
            $in_array = " AND usertype IN (" . $type . ")";
        } else {
            $in_array = '';
        }
        $patterns = array(
            '/#name/i', '/#username/i'
        );
        $replacements = array(
            "'||name||'", "'||username||'"
        );
        $sms = preg_replace($patterns, $replacements, $message);
        foreach (explode(',', $list_schema) as $schema) {
            $value = str_replace("'", null, $schema);
            $sql = "insert into public.sms (body,user_id,type,phone_number,sms_keys_id) select '{$sms}',id,'0',phone, (select id from public.sms_keys limit 1) from admin.all_users WHERE schema_name::text IN ($schema) AND usertype !='Student' {$in_array} AND  phone is not NULL  AND \"table\" !='setting' ";
            DB::statement($sql);
        }

        return redirect('message/create');
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

    public function psms($param) {
        
    }

    public function createUpdate() {
        if ($_POST) {
            $this->validate(request(), [
                'for' => 'required',
                'message' => 'required',
                'release_date' => 'date'
            ]);
            DB::table('admin.updates')->insert(array_merge(request()->except(['_token', '_wysihtml5_mode', 'for', 'subject']), ['for' => implode(',', request('for'))]));
            $message_success = 'Update recorded successfully';
            $schemas = (new \App\Http\Controllers\DatabaseController())->loadSchema();
            foreach ($schemas as $schema) {
                if (!in_array($schema->table_schema, ['public', 'constant', 'admin', 'dodoso', 'app'])) {
                    $users = DB::table($schema->table_schema . '.users')->whereIn('usertype', request('for'))->get();
                    foreach ($users as $user) {
                        if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                            DB::table($schema->table_schema . '.email')->insert(array(
                                'email' => $user->email,
                                'body' => str_replace('href="', 'href="' . $schema->table_schema . '.shulesoft.com/', request('message')),
                                'subject' => strlen(request('subject')) > 4 ? request('subject') : 'ShuleSoft Latest Updates: ' . request('release_date'),
                                'user_id' => $user->id,
                                'table' => $user->table
                            ));
                        }
                    }
                }
            }
            return redirect('message/shulesoft');
        }
        $this->data['usertypes'] = DB::select('select distinct usertype from admin.all_users');
        return view('message.add_updates', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pg) {
        //

        if (method_exists($this, $pg) && is_callable(array($this, $pg))) {
            return $this->$pg();
        } else {
            die('Page under construction');
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($type, $id = null, $schema = null) {
        if ($type == 'email' && (int) $id > 0 && strlen($schema) > 3) {
            DB::statement('delete  from ' . $schema . '.' . $type . ' where email_id=' . $id);
            return redirect(url('message/show/email'));
        }
    }

    public function shulesoft() {
        $message_success = '';

        $usertypes = DB::select('select distinct usertype from admin.all_users');
        return view('message.updates', compact('usertypes', 'message_success'));
    }

    public function feedback() {
        $feedbacks = \App\Models\Feedback::orderBy('id', 'desc')->paginate();
        return view('message.feedback', compact('feedbacks'));
    }

    public function website() {
        $feedbacks = \App\Models\Feedback::orderBy('id', 'desc')->paginate();
        return view('message.website', compact('feedbacks'));
    }

    public function reply() {
        $message = request('message');
        $message_id = request('message_id');
        \App\Models\Feedback_reply::create(['feedback_id' => $message_id, 'message' => $message, 'user_id' => Auth::user()->id]);
        $feedback = \App\Models\Feedback::find($message_id);

        $user = DB::table('admin.all_users')->where('id', $feedback->user_id)->where('table', $feedback->table)->where('schema_name', str_replace('.', NULL, $feedback->schema))->first();
        if (count($user) == 1) {
            $key = DB::table('public.sms_keys')->first();
            DB::table('public.sms')->insert(['body' => "Majibu ya ujumbe:" . $feedback->message . ". Jibu: " . $message, 'phone_number' => $user->phone, 'type' => 0, 'sms_keys_id' => $key->id]);

            $reply_message = '<div>'
                    . '<p><b>Majibu ya ujumbe:: </b> ' . $feedback->message . '</p><br/><br/>Jibu:' . $message . '</div>';
            DB::table('public.email')->insert(['body' => $reply_message, 'user_id' => $feedback->user_id, 'subject' => 'ShuleSoft Feedback Reply', 'email' => $user->email]);
            echo 'Message and Email sent';
        } else {
            echo 'user not found';
        }
    }

    public function sendSms() {
        //     //get all connected phones first, we use parallel approach to implement this
        //     DB::select('REFRESH MATERIALIZED VIEW  public.all_sms');
        //     $phones_connected = DB::select('select distinct api_key from public.all_sms');
        //     if (count($phones_connected) > 0) {
        //         foreach ($phones_connected as $phone) {
        //             $messages = DB::select('select * from public.all_sms where api_key=\'' . $phone->api_key . '\' order by priority desc, sms_id asc limit 100');
        //             if (!empty($messages)) {
        //                 foreach ($messages as $sms) {
        //                     //here put options to send sms by channels
        //                     $this->sendByChannel($sms);
        //                 }
        //             }
        //         }
        //     }
    }

    /**
     * @uses We use this method to format SMS into a format easy to be understood by end user
     * @param type $sms
     * @return string
     */
    private function formatMessage($sms) {
        $schema = strtoupper($sms->schema_name) == 'PUBLIC' ? 'SHULESOFT' : $sms->schema_name;
        if ((int) $sms->type == 1) {
            $school_link = '';
            $start_link = '';
        } else {
            $link = strtoupper($sms->schema_name) == 'PUBLIC' ? '' : $sms->schema_name . '.';
            $school_link = '. https://' . $link . 'shulesoft.com';
            $start_link = strtoupper($schema) . ': ' . '';
        }
        $message = $start_link . $sms->body . $school_link;
        return $message;
    }

    /**
     * @info: One messsage can be sent via multiple channels, but we need results of all channels
     * @param type $sms
     */
    public function sendByChannel($sms) {
        $category = explode(',', $sms->channel);
        $return = [];
        echo 'send sms by channel';
        if (empty($category)) {
            echo 'phone and quick message';
            $send = $this->sendNormalSMS($sms, 'phone-sms');
            array_push($return, ['phone-sms' => $send]);
            return DB::table($sms->schema_name . '.sms')->where('sms_id', $sms->sms_id)
                            ->update(['status' => 1, 'return_code' => json_encode($return), 'updated_at' => 'now()']);
        } else {
            foreach ($category as $channel) {

                if ($channel == 'whatsapp') {
                    echo 'whatsapp message';
                    $send = $this->whatsapp($sms);
                    array_push($return, [$channel => $send]);
                }
                if ($channel == 'telegram') {
                    echo 'Telegram message';
                    $send = $this->telegram($sms);
                    array_push($return, [$channel => $send]);
                }
                if ($channel == 'phone-sms' || $channel == 'quick-sms' || $channel == '') {
                    echo 'phone and quick message';
                    $send = $this->sendNormalSMS($sms, $channel);
                    array_push($return, [$channel => $send]);
                }
                if ($channel == 'email') {
                    echo 'email message';
                    $send = $this->sendCustomEmail($sms);
                    array_push($return, [$channel => $send]);
                }
            }
            return DB::table($sms->schema_name . '.sms')->where('sms_id', $sms->sms_id)
                            ->update(['status' => 1, 'return_code' => json_encode($return), 'updated_at' => 'now()']);
        }
    }

    public function sendCustomEmail($sms) {
        $user = \DB::table($sms->schema_name . 'users')->where('phone', $sms->phone_number)->first();
        $return = 0;
        if (!empty($user)) {
            if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                try {

                    $link = strtoupper($sms->schema_name) == 'PUBLIC' ? 'demo.' : $sms->schema_name . '.';
                    $data = ['content' => $sms->body, 'link' => $link, 'photo' => $user->photo, 'sitename' => $sms->schema_name, 'name' => $user->name];
                    $message = (object) ['sitename' => $sms->schema_name, 'email' => $user->email, 'subject' => $sms->subject];
                    $return = \Mail::send('email.default', $data, function ($m) use ($message) {
                                $m->from('noreply@shulesoft.com', $message->sitename);
                                $m->to($message->email)->subject($message->subject);
                            });
                } catch (\Exception $e) {
                    $return = $e->getMessage();
                }
            }
        }
        return $return;
    }

    public function sendNormalSMS($sms, $channel) {
        $karibusms = new \karibusms();
        $karibusms->API_KEY = $sms->api_key;
        $karibusms->API_SECRET = $sms->api_secret;
        $karibusms->set_name(strtoupper($sms->schema_name));
        $karibusms->karibuSMSpro = $channel == 'quick-sms' ? 1 : 0;
        return (object) json_decode($karibusms->send_sms($sms->phone_number, $this->formatMessage($sms), $sms->schema_name . $sms->sms_id));
    }

    public function whatsapp($sms) {

        $id = str_replace('+', NULL, $sms->phone_number) . '@c.us';
        $this->APIurl = $sms->api_secret;
        $this->token = $sms->api_key;
        if (strlen($sms->files) > 4) {

            $files = explode(',', $sms->files);
            foreach ($files as $file) {
                if (preg_match('/.ogg/i', $file)) {
                    $this->file($id, 'ogg', $file, NULL);
                } else {
                    $this->file($id, explode('.', $file)[1], $file, NULL);
                }
            }
            return $this->sendMessage($id, $sms->body);
        } else {
            return $this->sendMessage($id, $sms->body);
        }
    }

    public function telegram($sms) {
        $telegram_subscriber = DB::table('admin.telegram_users')->where('phone_number', $sms->phone_number)->first();
        if (!empty($telegram_subscriber)) {
            $bot_token = '1414183991:AAFORE9WoKxEtUk6se9Xjq5VIRraVO8fkp0';
            $telegram = new Telegram($bot_token);
            $message = array('chat_id' => $telegram_subscriber->telegram_id, 'text' => strtoupper($sms->schema_name) . chr(10) . $sms->body . chr(10) . 'https://' . $sms->schema_name . '.shulesoft.com', 'parse_mode' => 'HTML');
            return $telegram->sendMessage($message);
        }
    }

    public function sendEmail() {
return false;
        //loop through schema names and push emails
        $emails = DB::select('select * from public.email limit 8');
        $total_emails = !empty($emails) ? count($emails) : 0;
        if (count($emails) > 0) {
            foreach ($emails as $message) {
                if (filter_var($message->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $message->email)) {
                    try {
                        $link = strtoupper($message->schema_name) == 'PUBLIC' ? 'demo.' : $message->schema_name . '.';
                        $data = ['content' => $message->body, 'link' => $link, 'photo' => $message->photo, 'sitename' => $message->sitename, 'name' => ''];
                        $mail = \Mail::send('email.default', $data, function ($m) use ($message) {
                                    $m->from('noreply@shulesoft.africa', $message->sitename);
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
                sleep(2);
            }
        }
        echo '>> Emails sent : Total count =' . $total_emails . chr(10);
    }

    public function karibusmsEmails() {
        $this->emails = DB::connection('karibusms')->select('select * from emails where status=0 limit 8');
        if (count($this->emails) > 0) {
            foreach ($this->emails as $message) {
                if (filter_var($message->email, FILTER_VALIDATE_EMAIL)) {
                    try {
                        $link = 'www.karibusms.com';
                        $data = ['content' => $message->content, 'link' => $link, 'name' => ''];
                        \Mail::send('email.karibusms', $data, function ($m) use ($message) {
                            $m->from('noreply@shulesoft.africa', 'karibuSMS');
                            $m->to($message->email)->subject($message->subject);
                        });

                        if (count(\Mail::failures()) > 0) {
                            DB::connection('karibusms')->statement('update emails set status=0 WHERE id=' . $message->id);
                        } else {

                            DB::connection('karibusms')->statement('update emails set status=1 WHERE id=' . $message->id);
                        }
                    } catch (\Exception $e) {

                        echo 'something is not right' . $e->getMessage();
                    }
                }
//$this->updateEmailConfig();
                sleep(2);
            }
        }
    }

    public function paymentReminder() {
        $default_deadlines = DB::table('accounts.student')->get(['name', 'student_id', 'username', 'email', 'phone']);

        foreach ($default_deadlines as $school) {
            $payment = DB::table('accounts.payments')->where('student_id', $school->student_id)->orderBy('id', 'desc')->first();
            if (empty($payment)) {
                continue;
            }
            $now = date('Y-m-d'); // or your date as well
            $your_date = date('Y-m-d', strtotime($payment->next_payment_date));
            $date1 = new \DateTime($now);
            $date2 = new \DateTime($your_date);
            $days = $date2->diff($date1)->format("%a");
            print_r($days);
            echo '<br/>';
            if (in_array($days, [30, 15, 7, 3, 1, 18])) {
                $message = 'Dear ' . $school->name . '<br/>,

This is a reminder that your ShuleSoft Account is going to expire on  ' . date('d M Y', strtotime($payment->next_payment_date)) . '.<br/>
Kindly consider to make payments before due time. 

<h2>Payment Instructions</h2>
<ul>
<li>Login into your ShuleSoft Account</li>
<li>Go to setting tab</li>
<li>Then click upgrade ShuleSoft service</li>
<li>Create your reference/invoice number</li>
<li>Choose your payment method, either bank, wakala, sim banking or mobile payments</li>
</ul>
If you need any assistance, please contact us by replying to this email.

Thank you.';

                if (filter_var($school->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $school->email)) {
                    DB::statement("insert into " . $school->username . ".email (email,subject,body) values ('" . $school->email . "', 'Payment Reminder','" . $message . "')");
                }
                DB::statement("insert into " . $school->username . ".sms (phone_number,body,type) values ('" . $school->phone . "','" . strip_tags($message) . "',0)");
            } else if ($days <= 0 && in_array($days, [0, -2, -5, -10])) {
                $message = 'Hi ' . $school->name . '<br/>,
                This is the reminder that your ShuleSoft account has been expired since ' . date('d M Y', strtotime($payment->next_payment_date)) . ' . This means your management staff and parents are now not able to login, view any report, prepare any report. If you have any challange on how to make your payment kindly call us and let us know your concern. <br/>

Kind regards,';
                if (filter_var($school->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $school->email)) {
                    DB::statement("insert into " . $school->username . ".email (email,subject,body) values ('" . $school->email . "', 'Payment Reminder','" . $message . "')");
                }
                DB::statement("insert into " . $school->username . ".sms (phone_number,body,type) values ('" . $school->phone . "','" . strip_tags($message) . "',0)");
            }
        }
    }

    public function showreply() {
        $update = \App\Models\Feedback::find(request('message_id'));
        $update->update(['shared' => request('status') == 'false' ? 1 : 0]);
        return 1;
    }

    public function delete() {
        if (request('type') == 'website') {
            DB::table('website_contact_us')->where('id', request('id'))->delete();
            echo 'success';
        }
        return 1;
    }

    //this is the temporaly function to sync sms uploaded manually
    public function syncSms() {
        $contents = DB::table('admin.phone_sms')->where('published', 0)->limit(20)->get();
        foreach ($contents as $content) {

            $check_phone = validate_phone_number($content->address);

            if (!in_array($check_phone[1], array('+255714825469', '100', '+255652160360', '+255753867887')) && count($check_phone) == 2 && $content->type == 'Inbox') {
                $phone = $check_phone[1];
                $array = array(
                    'secret' => time(),
                    'from' => $phone,
                    'message_id' => $content->slot,
                    'message' => $content->body,
                    'sent_timestamp' => strtotime($content->date),
                    'sent_to' => $content->slot,
                    'device_id' => '3234223',
                );

                $user = \collect(DB::select("select * from admin.all_users where phone='" . $phone . "' and usertype !='Student' "))->first();
                if (count($user) > 0) {
                    $check = DB::table($user->schema_name . '.reply_sms')->where('message', $content->body)->where('from', $phone)->get();
                    if (count($check) == 0) {
                        DB::table($user->schema_name . '.reply_sms')->insert(array_merge($array, array(
                            'user_id' => $user->id,
                            'table' => $user->table
                        )));
                    }
                } else {
                    //save to public schema
                    DB::table('reply_sms')->insert($array);
                }
            }
            $content->update(['published' => 1]);
        }
    }

    public function checkPhoneStatus() {
//        $phones_connected = DB::select('select * from admin.all_sms_keys');
//        foreach ($phones_connected as $sms) {
//            $karibusms = new \karibusms();
//            $karibusms->API_KEY = $sms->api_key;
//            $karibusms->API_SECRET = $sms->api_secret;
//            $result = (object) json_decode($karibusms->check_phone_status());
////2020-08-06 20:07:28
//            $last_online = isset($result->last_online) ? $result->last_online : date('d-m-Y H:i');
//
//            $time = strtotime($last_online);
//            $tz_date = strtotime('-7 hours', $time);
//
//
//            $current_time = date('d-m-Y H:i', strtotime('+3 hours', time()));
//            $sms_time = date('d-m-Y H:i', $tz_date);
//
//
//            $to_time = strtotime($current_time);
//            $from_time = strtotime($sms_time);
//            $minutes = round(abs($to_time - $from_time) / 60, 2);
//
//            if ((int) $minutes > 120) {
//                // echo $last_online . 'More than 120min the device is offline';
////                $message = "Hello, Your phone appears to be offline for more than 2 hours. For SMS to be sent from karibuSMS, kindly make sure your phone is connected with internet and you have logged in, or try to logout and login again. Thank you";
////                $users = DB::table('admin.all_users')->where('schema_name', $sms->schema_name)->where('usertype', 'Admin')->get();
////                
////                foreach ($users as $user) {
////                    if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
////                        DB::statement("insert into public.email (email,subject,body) values ('" . $user->email . "', 'Payment Reminder','" . $message . "')");
////                    }
////                    DB::statement("insert into public.sms (phone_number,body,type) values ('" . $user->phone . "','" . strip_tags($message) . "',0)");
////                }
//            }
//        }
    }

}
