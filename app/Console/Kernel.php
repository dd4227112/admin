<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Message;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Background;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
// \App\Console\Commands\Inspire::class,
        \App\Console\Commands\SendDailyReport::class,
        \App\Console\Commands\SendWhatsappSms::class,
        \App\Console\Commands\InsertData::class,
        \App\Console\Commands\SendNormalSms::class,
        \App\Console\Commands\SendBirhdayWishes::class,
        \App\Console\Commands\SendTaskReminder::class,
        \App\Console\Commands\SendNotice::class,
        \App\Console\Commands\SendTodoRemainder::class,
        \App\Console\Commands\SetTaskRemainder::class,
        \App\Console\Commands\SyncInvoice::class,
        \App\Console\Commands\SendQuickSms::class,
        \App\Console\Commands\FindMissingPayments::class,
        \App\Console\Commands\StandingOrderRemainder::class,
        \App\Console\Commands\HRContractRemainders::class,
        \App\Console\Commands\DatabaseOptimization::class,
       // \App\Console\Commands\CreateTodayReport::class,
        \App\Console\Commands\SchoolMonthlyReport::class,
            // \App\Console\Commands\HRLeaveRemainders::class, // Currently disabled
            // \App\Console\Commands\RefreshMaterializedView::class, // Currently disabled
            // \App\Console\Commands\SendSequenceReminder::class, // Currently disabled
    ];
    public $emails;

    protected function schedule(Schedule $schedule) {

        // send BirthDay Wishes, configure the service set RestartSec = 1 minute (60s)
        try {
            $schedule->command('send:birthdaywishes')->dailyAt('04:40');
        } catch (\Exception $e) {
            Log::error('Send birthday wishes to students every day failed' . $e->getMessage());
        }


        // configure the service set RestartSec = 1 minute (60s)
        try {
            $schedule->command('send:reminder')->dailyAt('04:40');
        } catch (\Exception $e) {
            Log::error('Send task reminders failed' . $e->getMessage());
        }

        // configure the service set RestartSec = 1 minute (60s)
        try {
            $schedule->command('send:notice')->dailyAt('04:40');
        } catch (\Exception $e) {
            Log::error('Send Remainder failed' . $e->getMessage());
        }
        // configure the service set RestartSec = 1 minute (60s)
        try {
            $schedule->command('send:todoremider')->dailyAt('03:40');
        } catch (\Exception $e) {
            Log::error('Send todo reminder failed' . $e->getMessage());
        }
        // configure the service set RestartSec = 1 hour (60*60s)
        try {
            $schedule->command('set:taskreminder')->hourly();
        } catch (\Exception $e) {
            Log::error('set reminder failed' . $e->getMessage());
        }

        // configure the service set RestartSec = 1 minute (60s)
        try {
            $schedule->command('whatsapp:sms')->everyMinute();
        } catch (\Exception $e) {
            Log::error('Send a WhatsApp SMS failed: ' . $e->getMessage());
        }

        // configure the service set RestartSec = 1 minute (60s)
        try {
            $schedule->command('sync:invoice')->everyMinute();
        } catch (\Exception $e) {
            Log::error('Sync Invoice failed: ' . $e->getMessage());
        }

        // configure the service set RestartSec = 1 minute (60s)
        try {
            $schedule->command('send:quicksms')->everyMinute();
        } catch (\Exception $e) {
            Log::error('Send Quick SMS failed: ' . $e->getMessage());
        }
        // configure the service set RestartSec = 2hours (60*2*60s)
        try {
            $schedule->command('find:payment')->everyTwoHours();
        } catch (\Exception $e) {
            Log::error('Find Missing Payments failed: ' . $e->getMessage());
        }

        // configure the service set RestartSec = 1 minute
        try {
            $schedule->command('standingorder:reminder')->dailyAt('03:40');
        } catch (\Exception $e) {
            Log::error('Set Standing Order reminder failed' . $e->getMessage());
        }
        // configure the service set RestartSec = 1 minute
        try {
            $schedule->command('contractor:reminder')->dailyAt('04:40');
        } catch (\Exception $e) {
            Log::error('HR contractor reminder failed' . $e->getMessage());
        }
        // configure the service set RestartSec = 1 minute
        try {
            $schedule->command('database:optimize')->dailyAt('00:40');
        } catch (\Exception $e) {
            Log::error('HR contractor reminder failed' . $e->getMessage());
        }
        // configure the service set RestartSec = 1 minute
        try {
            $schedule->command('today:report')->dailyAt('14:50');
        } catch (\Exception $e) {
            Log::error('Daily Report failed' . $e->getMessage());
        }

        // configure the service set RestartSec = 1 minute
        try {
            $schedule->command('schoolmontly:report')->monthlyOn(28, '06:36');
        } catch (\Exception $e) {
            Log::error('School Montly Report failed' . $e->getMessage());
        }

        // configure the service set RestartSec = 1 minute currently disabled
        // try {
        //     $schedule->command('leave:reminder')->dailyAt('04:40');
        // } catch (\Exception $e) {
        //     Log::error('HR Leave Reminder failed' . $e->getMessage());
        // }
        // configure the service set RestartSec = 1 hour (60*60s) currently disabled
        // try {
        //     $schedule->command('refresh:view')->twiceDaily(1, 13);
        // } catch (\Exception $e) {
        //     Log::error('Refresh Materialized View failed' . $e->getMessage());
        // }
        // configure the service set RestartSec = 1 minute (60s) currently disabled
        // try {
        //     $schedule->command('send:sequence')->dailyAt('04:40');
        // } catch (\Exception $e) {
        //     Log::error('Sequence Remiinder failed' . $e->getMessage());
        // }
        // try {
        //     $schedule->command('report:send')->everyMinute();
        // } catch (\Exception $e) {
        //     Log::error('send daily report failed: ' . $e->getMessage());
        // }
        // try {
        //     $schedule->command('send:normal-sms')->everyMinute();
        // } catch (\Exception $e) {
        //     Log::error('Whatsapp command failed: ' . $e->getMessage());
        // }

        $schedule->call(function () {
            //sync invoices 
            $this->sendQuickSms();  // done 
            $this->syncInvoice(); //done
            //  $this->syncData();
            $this->pushWhatsappMessageOnly(); //done
            $this->whatsappMessage(); // done

            //(new Message())->sendEmail();
        })->everyMinute();

        $schedule->call(function () {
            //remaind tasks to users and allocated users
            $this->setTaskRemainder(); //done
            DB::select('refresh  materialized view  admin.all_sms ');
        })->hourly();

        $schedule->call(function () {
            $this->sendTodReminder(); //done
        })->dailyAt('03:30'); // Eq to 06:30 AM 


        $schedule->call(function () {

            $this->sendBirthdayWish(); // done
            $this->sendTaskReminder(); //done
            $this->sendNotice(); //done
            // $this->sendSequenceReminder(); //done
        })->dailyAt('04:40'); // Eq to 07:40 AM 


        $schedule->call(function () {
            $this->findMissingPayments(); // done
        })->everyTwoHours();

        $schedule->call(function () {
            $this->standingOrderRemainder(); //done
        })->dailyAt('03:40'); // Eq to 06:40 AM   

        $schedule->call(function () {
            $this->HRContractRemainders(); //done
            //  $this->HRLeaveRemainders(); //done
        })->dailyAt('04:40'); // Eq to 07:40 AM   


        $schedule->call(function () {
            $this->databaseOptimization(); //done
        })->dailyAt('00:40'); // Eq to 03:40 AM   

        $schedule->call(function () {
            // $this->RefreshMaterializedView(); //done
        })->twiceDaily(1, 13); // Run the task daily at 1:00 & 13:00


        $schedule->call(function () {
           // (new Customer())->createTodayReport(); //done
        })->dailyAt('14:50'); // Eq to 17:50 h 


        $schedule->call(function () {
            (new Background())->schoolMonthlyReport(); //done
        })->monthlyOn(28, '06:36');
    }

    public function databaseOptimization() {
        $clients = DB::table('admin.clients')->where('status', 1)->where('is_new_version', 0)->get();
        foreach ($clients as $client) {
            if ($client->is_new_version == 1) {
                DB::SELECT('SELECT * FROM shulesoft.redistribute_all_student_payments(' . $client->username . ')');
            } else {
                DB::SELECT('SELECT * FROM ' . $client->username . ' redistribute_all_student_payments()');
            }
        }
    }

    public function sendQuickSms() {
        $schemas = DB::select('select schema_name from admin.sms_status');
        $total_sms_sent = 0;
        foreach ($schemas as $schema_) {
            $schema = $schema_->schema_name;

            $messages = DB::select("select a.phone_number as phone, a.body  as body, a.sms_id as id, a.sent_from from " . $schema . ".sms a where a.status = 0 and a.type = 1 order by priority DESC limit 30");
            $total_sms_sent += !empty($messages) ? count($messages) : 0;

            if (!empty($messages)) {
                foreach ($messages as $message) {
                    $beem = $this->beem_sms($message->phone, $message->body, $schema);
                    DB::table($schema . ".sms")->where('sms_id', $message->id)->update([
                        'status' => 1,
                        'return_code' => json_encode($beem),
                        'updated_at' => 'now()'
                    ]);
                }
            }
        }
        echo '>> Quick SMS sent : Total ' . $total_sms_sent . chr(10);
    }

    function beem_sms($phone_number, $message, $schema_ = null) {
        if ($phone_number != '') {
            $secret_key = 'MDI2ZGVlMWExN2NlNzlkYzUyYWE2NTlhOGE0MjgyMDRmMjFlMDFjODkwYjU2NjA4OTY4NzZlY2Y3NGZjY2Y0Yw==';
            $api_key = '5e0b7f1a911dd411';

            $schema = $schema_ == null ? str_replace('.', null, set_schema_name()) : $schema_;

            if ($schema == 'annagamazo') {
                $sender_name = 'ANNAGAMAZO';
            } elseif ($schema == 'rahma') {
                $sender_name = 'RAHMASCHOOL';
            } elseif ($schema == 'capricorninstitute') {
                $sender_name = 'CAPRICORN';
            } elseif ($schema == 'mgutwasec') {
                $sender_name = 'MGUTWA SECONDARY';
            } else {
                $sender_name = 'SHULESOFT';
            }

            // The data to send to the API
            $posthData = array(
                'source_addr' => $sender_name,
                'encoding' => 0,
                'schedule_time' => '',
                'message' => $message,
                'recipients' => [array('recipient_id' => '1', 'dest_addr' => str_replace('+', null, $phone_number))]
            );

            //.... Api url
            $Url = 'https://apisms.beem.africa/v1/send';
            // Setup cURL
            $ch = curl_init($Url);
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                    'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => json_encode($posthData)
            ));

// Send the request
            $response = curl_exec($ch);
            // response of the POST request
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $responseBody = json_decode($response);
            curl_close($ch);

            if ($httpCode >= 200 && $httpCode < 300) {
                $return = $this->status_code('1701');
            } else {
                $return = $this->status_code(1700);
            }


            // Check for errors
        } else {
            $return = $this->status_code(1700);
        }

        return $return;
    }

    private function status_code($result) {

        switch ($result) {
            case '1701':
                $status = array(
                    'success' => 1,
                    'message' => 'Message sent successful'
                );
                break;
            case '1702':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid URL Error,one of the parameters was not provided or left blank'
                );
                break;
            case '1703':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid value'
                );
                break;
            case '1704':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid value type'
                );
                break;
            case '1705':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid message'
                );
                break;
            case '1706':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid destination'
                );
                break;
            case '1707':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid Source (Sender)'
                );
                break;
            case '1709':
                $status = array(
                    'success' => 0,
                    'message' => 'User validation failed'
                );
                break;
            case '1710':
                $status = array(
                    'success' => 0,
                    'message' => 'Internal error'
                );
                break;
            case '1025':
                $status = array(
                    'success' => 0,
                    'message' => 'Insufficient credit, contact sales@karibusms.com to recharge your account'
                );
                break;
            default :
                $status = array(
                    'success' => 0,
                    'message' => 'No format results specified'
                );
                break;
        }
        $code = array('code' => $result);
        $results = array_merge($status, $code);

        return json_encode($results);
    }

    public function appendAd($phone) {
        $message = '';
        $check = \collect(DB::select("select * from api.parent_experience_logs where admin.whatsapp_phone(phone)='admin.whatsapp_phone(" . $phone . ")'"))->first();
        if (empty($check)) {
            $message = 'Download Parent Experience App here: '
                    . 'Android: https://cutt.ly/ssape , '
                    . 'Iphone: https://cutt.ly/ssipe';
        }
        return $message;
    }

    public function whatsappMessage() {
        $messages = DB::select('select * from admin.whatsapp_messages where status=0 order by id asc limit 29');
        $controller = new \App\Http\Controllers\Controller();
        $total_count = !empty($messages) ? count($messages) : 0;
        foreach ($messages as $message) {
            if (preg_match('/@c.us/i', $message->phone) && strlen($message->phone) < 19) {

                //Advertise our parent Experience app
                $add = $this->appendAd($message->phone);
                if (!empty($message->company_file_id)) {
                    $file = \App\Models\CompanyFile::find($message->company_file_id);
                    $controller->sendMessageFile($message->phone, $message->message . $add, $file->name, $file->path);
                } else {
                    $controller->sendMessage($message->phone, $message->message . $add);
                }
                DB::table('admin.whatsapp_messages')->where('id', $message->id)->update(['status' => 1, 'updated_at' => now()]);
                //   echo 'message sent to ' . $message->phone . '' . chr(10);
                sleep(0.8);
            } else {
                //this is invalid number, so update in db to show wrong return
                DB::table('admin.whatsapp_messages')->where('id', $message->id)->update(['status' => 1, 'return_message' => 'Wrong phone number supplied', 'updated_at' => now()]);
            }
        }
        echo '>> Whatsapp Messages sent : Total sent =' . $total_count . chr(10);
    }

    public function pushWhatsappMessageOnly() {
        DB::select('refresh materialized view admin.all_sms');
        DB::select('refresh materialized view admin.all_sms_files');
        $messages = DB::select("select admin.whatsapp_phone(a.phone_number) as phone,  a.sms_id as id, a.schema_name||': '||a.body || ' \n School Link > https://'||a.schema_name||' .shulesoft.co' as body, 1 as is_old_version, a.schema_name, b.url as file_url from admin.all_sms a left join admin.all_sms_files b on (b.schema_name=a.schema_name and a.sms_content_id=b.sms_content_id) where sent_from = 'whatsapp' and status=0 
UNION 
select admin.whatsapp_phone(a.phone_number) as phone,  a.sms_id as id, a.schema_name||':'||a.body || ' . \n  School Link > https://'||a.schema_name||' .shulesoft.africa' as body, 0 as is_old_version, a.schema_name, b.url as file_url from shulesoft.sms a  left join shulesoft.sms_files b on (b.schema_name=a.schema_name and a.sms_content_id=b.sms_content_id) where  sent_from='whatsapp' and status = 0  limit 30");
        $bot = new \App\Http\Controllers\Controller();

        if (count($messages) > 0) {
            foreach ($messages as $message) {
                $id = (int) $message->id;
                //send whatsapp message
                $chat_id = $message->phone;
                $add = $this->appendAd($message->phone);
                
                if (strlen($message->file_url) > 5) {
                    $bot->sendMessageFile($chat_id, strtoupper($message->schema_name) . ' Sent File ', $message->schema_name, $message->file_url);
                } else {
                    $bot->sendMessage($chat_id, $message->body . $add, $message->schema_name);
                }

                (int) $message->is_old_version == 1 ? DB::table($message->schema_name . ".sms")->where('sms_id', $id)->update([
                                    'status' => 1,
                                    'return_code' => 'sent by whatsapp :admin-kernel',
                                    'updated_at' => 'now()'
                                ]) : DB::table("shulesoft.sms")->where('schema_name', $message->schema_name)->where('sms_id', $id)->update([
                                    'status' => 1,
                                    'return_code' => 'sent by whatsapp :admin-kernel',
                                    'updated_at' => 'now()'
                ]);
                sleep(0.8);
            }
        }
        echo '>> Whatsapp Messages for other schools sent : Total sent =' . count($messages) . chr(10);
    }

    function checkPaymentPattern($user, $schema) {
        $pattern = [0, 0, 0];
        if ($user->table == 'parent') {
            $sql = 'select  coalesce(coalesce(sum(a.total_amount),0)-sum(a.discount_amount),0) as amount, '
                    . 'coalesce(coalesce(sum(a.total_payment_invoice_fee_amount),0)+ coalesce(sum(a.total_advance_invoice_fee_amount)),0) as paid_amount, '
                    . 'sum(a.balance) as balance, a.invoice_id as id,a.student_id, c.reference, '
                    . 'b.name as student_name, a.created_at,f.phone,f.name as parent_name,f.username'
                    . ' from shulesoft.invoice_balances a join shulesoft.student b on'
                    . ' (a.student_id=b.student_id and a.schema_name=b.schema_name)'
                    . ' JOIN  shulesoft.student_parents e on '
                    . ' (e.student_id=b.student_id and e.schema_name=b.schema_name) join'
                    . ' shulesoft.parent f on (f."parentID"=e.parent_id and f.schema_name=e.schema_name) JOIN'
                    . '  shulesoft.invoices c on c.id=a.invoice_id where e.schema_name=\'' . $schema . '\' and e.parent_id=' . $user->id . ' and'
                    . '  a.student_id in (select student_id from shulesoft.student_archive where schema_name=\'' . $schema . '\' and section_id in '
                    . ' (select "sectionID" FROM shulesoft.section where schema_name=\'' . $schema . '\' ) )'
                    . '  group by a.invoice_id,a.created_at,b.name ,a.student_id,c.reference,f.phone,f.name,f.username ';
            $parent = \collect(DB::select($sql))->first();
            if (!empty($parent)) {
                $pattern = [$parent->balance, $parent->student_name, $parent->reference];
            }
        }
        return $pattern;
    }

    public function saveSms($schema, $phone, $body, $user_id) {
        return DB::table('shulesoft.sms')->insert(array('phone_number' => $phone,
                    'body' => $body,
                    'schema_name' => $schema,
                    'user_id' => $user_id,
                    'type' => 0));
    }

    public function saveEmail($schema, $email, $body, $user_id, $title) {
        return DB::table('shulesoft.email')->insert(array('email' => $email,
                    'body' => $body,
                    'schema_name' => $schema,
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
        $invoices = DB::select("select distinct a.schema_name from admin.all_bank_accounts_integrations  a JOIN admin.all_bank_accounts b on(a.bank_account_id=b.id  AND a.schema_name=b.schema_name) where b.refer_bank_id=22 and a.schema_name not in ('public') ");
        foreach ($invoices as $invoice) {
            $this->syncInvoicePerSchool($invoice->schema_name);
        }
        echo '>> Invoice Sync Completed : Count ' . count($invoices) . chr(10);
    }

    public function syncRevenueInvoice() {
        $invoices = DB::select("select distinct a.schema_name from admin.all_bank_accounts_integrations  a JOIN admin.all_bank_accounts b on(a.bank_account_id=b.id  AND a.schema_name=b.schema_name) where b.refer_bank_id=22 and a.schema_name not in ('public') ");
        foreach ($invoices as $invoice) {
            $this->syncRevenuePerSchool($invoice->schema_name);
        }
    }

    /**
     * Temporarily only allows digital invoice but must support both
     */
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

    /**
     * Temporarily only allows digital invoice but must support both
     */
    public function syncRevenuePerSchool($schema = '') {

        $invoices = DB::select("SELECT b.id, b.user_id, b.reference, b.status, (select invoice_prefix from  " . $schema . ".bank_accounts_integrations bi join  " . $schema . ".bank_accounts ba on bi.bank_account_id=ba.id where ba.refer_bank_id=22 limit 1) as prefix , b.date, b.created_at, b.updated_at, b.amount, b.payer_name, '" . $schema . "' as schema_name from  " . $schema . ".revenues b where status != 1 AND payment_type_id=6 order by random() limit 120");
        foreach ($invoices as $invoice) {
            echo 'push Normal  revenues for ' . $invoice->schema_name . '' . chr(10) . chr(10);
            $this->pushRevInvoice($invoice);
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

    public function updateInvoice() {
        $invoices = DB::select('select * from api.invoices where sync=2 and amount >0 order by random() limit 80');
        if (!empty($invoices)) {
            foreach ($invoices as $invoice) {
                $token = $this->getToken($invoice);
                if (strlen($token) > 4) {
                    $fields = array(
                        "reference" => trim($invoice->reference),
                        "student_name" => $invoice->student_name,
                        "student_id" => $invoice->student_id,
                        "allow_partial" => "TRUE",
                        "amount" => $invoice->amount,
                        //  "type" => $this->getFeeNames($invoice->id, $invoice->schema_name),
                        "type" => ucfirst($invoice->schema_name) . ' School Fees',
                        "code" => "10",
                        "callback_url" => "http://75.119.140.177:8081/api/init",
                        "token" => $token
                    );
                    $push_status = $invoice->status == 2 ? 'invoice_update' : 'invoice_submission';
                    // $push_status = 'invoice_update';
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
                    if (($result->status == 1 && strtolower($result->description) == 'success') || $result->description == 'Duplicate Invoice Number') {
//update invoice no
                        DB::table($invoice->schema_name . '.invoices')
                                ->where('id', $invoice->id)->update(['sync' => 1, 'return_message' => $curl, 'push_status' => $push_status, 'status' => 0, 'updated_at' => 'now()']);
                        //update invoice no
                        if ($result->description == 'Duplicate Invoice Number') {
                            DB::table($invoice->schema_name . '.invoice_prefix')
                                    ->where('id', $invoice->id)->update(['sync' => 0, 'return_message' => $curl, 'push_status' => $push_status, 'status' => 3, 'updated_at' => 'now()']);
                        }
                    }

                    DB::table('api.requests')->insert(['return' => json_encode($curl), 'content' => json_encode($fields)]);
                }
            }
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
        $all_students = [];
        foreach ($users as $user) {
            unset($all_users[$user->name]);
            $students = DB::SELECT('SELECT name FROM ' . $user->schema_name . '.student where student_id in(select student_id from ' . $user->schema_name . '.student_duties where duty_id=' . $user->duty_id . ')');
            foreach ($students as $student) {
                array_push($all_students, [$student->name]);
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
        if (!empty($users)) {
            foreach ($users as $user) {
                $message = 'Hello  ' . $user->name . ' ,'
                        . 'Activity to do: ' . $user->activity . ' for ' . $user->client_name . '. Kindly remember to write all activities in respective profile.  Thanks';
                DB::statement("insert into public.email (email,subject,body) values ('" . $user->email . "', 'Todays Tasks','" . $message . "')");
                $key = DB::table('public.sms_keys')->first();
                DB::statement("insert into public.sms (phone_number,body,type,sms_keys_id) values ('" . $user->phone . "','" . $message . "',0," . $key->id . " )");
            }
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
        DB::select('refresh materialized view admin.all_notice');
        $notices = DB::select("select * from admin.all_notice  WHERE  date-CURRENT_DATE=3 and status=0 ");
///these are notices
        foreach ($notices as $notice) {
//$class_ids = (explode(',', preg_replace('/{/', '', preg_replace('/}/', '', $notice->class_id))));
            $to_roll_ids = preg_replace('/{/', '', preg_replace('/}/', '', $notice->to_roll_id));

            $users = $to_roll_ids == 0 ?
                    DB::select("select *,(select id as sms_keys_id from " . $notice->schema_name . ".sms_keys limit 1 ) as sms_keys_id from admin.all_users where 'table' not in ('student', 'setting') AND schema_name::text='" . $notice->schema_name . "'") :
                    DB::select('select *,(select id as sms_keys_id from ' . $notice->schema_name . '.sms_keys limit 1 ) as sms_keys_id from admin.all_users where role_id IN (' . $to_roll_ids . ' ) and schema_name::text=\'' . $notice->schema_name . '\'  ');
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $message = 'Kalenda ya Shule:'
                            . 'Siku ya tukio : ' . $notice->date . ' ,'
                            . 'Jina la Tukio:  ' . $notice->notice . ','
                            . 'Kwa taarifa zaidi, tembelea akaunti yako ya ShuleSoft. Asante';

                    if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                        DB::statement("insert into " . $notice->schema_name . ".email (email,subject,body) values ('" . $user->email . "', 'Calender Reminder : " . $notice->title . "','" . $message . "')");
                    }
                    if (!empty($user->sms_keys_id)) {
                        DB::statement("insert into " . $notice->schema_name . ".sms (phone_number,body,type,sms_keys_id) values ('" . $user->phone . "','" . $message . "',0," . $user->sms_keys_id . " )");
                    }
                }
            }
        }
    }

    /**
     * Only paid users
     */
    public function sendBirthdayWish() {
        $schemas = DB::select("select username as table_schema, is_new_version from admin.clients where status=1 and username not in ('mustlead','millenniumkindergarten')");
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'betatwo', 'api', 'admin'))) {

                //Remind parents,class and section teachers to wish their students
                //insert into SMS and send as text message
                $sql = (int) $schema->is_new_version == 1 ?
                        "insert into shulesoft.sms (schema_name,body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "select '" . $schema->table_schema . "', 'Hello '|| c.name|| ', tunapenda kumtakia '||a.name||' heri ya siku yake ya kuzaliwa katika tarehe '|| a.dob ||'. Mungu ampe afya tele, maisha marefu, baraka na mafanikio.  Kama hajaziliwa tarehe '|| a.dob ||', tuambie tubadili tarehe zake ziwe sahihi. Ubarikiwe',c.phone, 0,0, c.\"parentID\",'parent', (select id from shulesoft.sms_keys where schema_name='" . $schema->table_schema . "' limit 1)  FROM shulesoft.student a join shulesoft.student_parents b on b.student_id=a.student_id JOIN shulesoft.parent c on c.\"parentID\"=b.parent_id WHERE 
                    a.schema_name='" . $schema->table_schema . "' and DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) AND a.status = 1 AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE)" :
                        "insert into {$schema->table_schema}.sms (body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "select 'Hello '|| c.name|| ', tunapenda kumtakia '||a.name||' heri ya siku yake ya kuzaliwa katika tarehe '|| a.dob ||'. Mungu ampe afya tele, maisha marefu, baraka na mafanikio.  Kama hajaziliwa tarehe '|| a.dob ||', tuambie tubadili tarehe zake ziwe sahihi. Ubarikiwe',c.phone, 0,0, c.\"parentID\",'parent', (select id from " . $schema->table_schema . ".sms_keys limit 1)  FROM " . $schema->table_schema . ".student a join " . $schema->table_schema . ".student_parents b on b.student_id=a.\"student_id\" JOIN " . $schema->table_schema . ".parent c on c.\"parentID\"=b.parent_id WHERE 
                    DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) AND a.status = 1 AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE)";
                DB::statement($sql);

                //insert to be sent as whatsapp message
                $sql2 = (int) $schema->is_new_version == 1 ?
                        "insert into shulesoft.sms (sent_from,schema_name,body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "select 'whatsapp', '" . $schema->table_schema . "', 'Hello '|| c.name|| ', tunapenda kumtakia '||a.name||' heri ya siku yake ya kuzaliwa katika tarehe '|| a.dob ||'. Mungu ampe afya tele, maisha marefu, baraka na mafanikio.  Kama hajaziliwa tarehe '|| a.dob ||', tuambie tubadili tarehe zake ziwe sahihi. Ubarikiwe',c.phone, 0,0, c.\"parentID\",'parent', (select id from shulesoft.sms_keys where schema_name='" . $schema->table_schema . "' limit 1)  FROM shulesoft.student a join shulesoft.student_parents b on b.student_id=a.student_id JOIN shulesoft.parent c on c.\"parentID\"=b.parent_id WHERE 
                    a.schema_name='" . $schema->table_schema . "' and DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) AND a.status = 1 AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE)" :
                        "insert into {$schema->table_schema}.sms (sent_from,body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "select 'whatsapp', 'Hello '|| c.name|| ', tunapenda kumtakia '||a.name||' heri ya siku yake ya kuzaliwa katika tarehe '|| a.dob ||'. Mungu ampe afya tele, maisha marefu, baraka na mafanikio.  Kama hajaziliwa tarehe '|| a.dob ||', tuambie tubadili tarehe zake ziwe sahihi. Ubarikiwe',c.phone, 0,0, c.\"parentID\",'parent', (select id from " . $schema->table_schema . ".sms_keys limit 1)  FROM " . $schema->table_schema . ".student a join " . $schema->table_schema . ".student_parents b on b.student_id=a.\"student_id\" JOIN " . $schema->table_schema . ".parent c on c.\"parentID\"=b.parent_id WHERE 
                    DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) AND a.status = 1 AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE)";
                DB::statement($sql2);

                //get students with birthday, with their section teacher names
                //get count total number of students with birthday today and send to admin
                $sql_for_teachers = (int) $schema->is_new_version == 1 ?
                        "insert into shulesoft.sms (schema_name,body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "SELECT '" . $schema->table_schema . "', 'Hello '||teacher_name||', leo ni birthday ya '||string_agg(student_name, ', ')||', katika darasa lako '||classes||'('||section||'). Usisite kumtakia heri ya kuzaliwa. Asante', phone,0,0,\"teacherID\",'teacher',(select id from shulesoft.sms_keys where schema_name='" . $schema->table_schema . "' limit 1 ) from ( select a.name as student_name, t.name as teacher_name, t.\"teacherID\", t.phone, c.section, d.classes from shulesoft.student a join shulesoft.section c on c.\"sectionID\"=a.\"sectionID\" JOIN shulesoft.teacher t on t.\"teacherID\"=c.\"teacherID\" join shulesoft.classes d on d.\"classesID\"=c.\"classesID\" WHERE"
                        . "   a.schema_name='" . $schema->table_schema . "' AND a.status=1 and  t.status=1 and  DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE)   AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE) ) x GROUP  BY"
                        . " teacher_name,phone,classes,section,phone,\"teacherID\"" :
                        "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "SELECT  'Hello '||teacher_name||', leo ni birthday ya '||string_agg(student_name, ', ')||', katika darasa lako '||classes||'('||section||'). Usisite kumtakia heri ya kuzaliwa. Asante', phone,0,0,\"teacherID\",'teacher',(select id from " . $schema->table_schema . ".sms_keys limit 1 ) from ( select a.name as student_name, t.name as teacher_name, t.\"teacherID\", t.phone, c.section, d.classes from " . $schema->table_schema . ".student a join " . $schema->table_schema . ".section c on c.\"sectionID\"=a.\"sectionID\" JOIN " . $schema->table_schema . ".teacher t on t.\"teacherID\"=c.\"teacherID\" join " . $schema->table_schema . ".classes d on d.\"classesID\"=c.\"classesID\" WHERE"
                        . "  a.status=1 and  t.status=1 and  DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE)   AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE) ) x GROUP  BY"
                        . " teacher_name,phone,classes,section,phone,\"teacherID\"";
                DB::statement($sql_for_teachers);

                //send to teachers whatsapp as well
                $sql_for_teachers2 = (int) $schema->is_new_version == 1 ?
                        "insert into shulesoft.sms (sent_from,schema_name,body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "SELECT 'whatsapp', '" . $schema->table_schema . "', 'Hello '||teacher_name||', leo ni birthday ya '||string_agg(student_name, ', ')||', katika darasa lako '||classes||'('||section||'). Usisite kumtakia heri ya kuzaliwa. Asante', phone,0,0,\"teacherID\",'teacher',(select id from shulesoft.sms_keys where schema_name='" . $schema->table_schema . "' limit 1 ) from ( select a.name as student_name, t.name as teacher_name, t.\"teacherID\", t.phone, c.section, d.classes from shulesoft.student a join shulesoft.section c on c.\"sectionID\"=a.\"sectionID\" JOIN shulesoft.teacher t on t.\"teacherID\"=c.\"teacherID\" join shulesoft.classes d on d.\"classesID\"=c.\"classesID\" WHERE"
                        . "   a.schema_name='" . $schema->table_schema . "' AND a.status=1 and  t.status=1 and  DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE)   AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE) ) x GROUP  BY"
                        . " teacher_name,phone,classes,section,phone,\"teacherID\"" :
                        "insert into " . $schema->table_schema . ".sms (sent_from,body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                        . "SELECT 'whatsapp', 'Hello '||teacher_name||', leo ni birthday ya '||string_agg(student_name, ', ')||', katika darasa lako '||classes||'('||section||'). Usisite kumtakia heri ya kuzaliwa. Asante', phone,0,0,\"teacherID\",'teacher',(select id from " . $schema->table_schema . ".sms_keys limit 1 ) from ( select a.name as student_name, t.name as teacher_name, t.\"teacherID\", t.phone, c.section, d.classes from " . $schema->table_schema . ".student a join " . $schema->table_schema . ".section c on c.\"sectionID\"=a.\"sectionID\" JOIN " . $schema->table_schema . ".teacher t on t.\"teacherID\"=c.\"teacherID\" join " . $schema->table_schema . ".classes d on d.\"classesID\"=c.\"classesID\" WHERE"
                        . "  a.status=1 and  t.status=1 and  DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE)   AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE) ) x GROUP  BY"
                        . " teacher_name,phone,classes,section,phone,\"teacherID\"";
                DB::statement($sql_for_teachers2);
            }
        }
        //Remind them in parent experience app as well as a push notification
        DB::statement('refresh materialized view admin.all_sms');
        $push_notification = "insert into admin.push_notifications (phone,schema_name,message) select phone_number, schema_name,body from admin.all_sms where created_at::date=current_date and lower(body) like '%birthday%' AND phone_number in (select phone from api.parent_experience_logs where schema_name='noschema') ";
        DB::statement($push_notification);
    }

    public function sendReportReminder() {
        $schemas = (new \App\Http\Controllers\Software())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin', 'kisaraweljs', 'laureatemikocheni', 'laureatembezi', 'lifewaylighschools', 'montessori', 'sullivanprovost', 'ubungomodern', 'whiteangles', 'atlasschools'))) {
                //parents
                $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', matokeo yote ya '||c.name||'  hupatikana kwenye ShuleSoft. Ili kuyaona, fungua https://" . $schema->table_schema . ".shulesoft.co, kisha nenda upande wa kushoto (sehemu imendikwa Exam Report (au Alama)) Kisha utaona matokeo yote. Kama umesahau neno siri lako ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then '123456' else p.default_password end||'.  Asante', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p join " . $schema->table_schema . ".student_parents sp on sp.parent_id=p.\"parentID\" JOIN " . $schema->table_schema . ".student c on c.\"student_id\"=sp.student_id, " . $schema->table_schema . ".setting s where p.status=1";
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
select 'Hello '|| p.name|| ', ili uweze kuingia katika program ya ShuleSoft, nenda sehemu ya internet (Google), kisha andika https://" . $schema->table_schema . ".shulesoft.co, kisha ingiza nenotumizi (username) ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then '123456' else p.default_password end||'. Matokeo yote ya mwanao na taarifa za shule utazipata ShuleSoft. Kwa msaada, piga (0655406004) au uongozi wa shule ('||s.phone||'). Asante', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p, " . $schema->table_schema . ".setting s where p.\"parentID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"user\"='Parent') and p.status=1";
        return DB::statement($sql);
    }

    public function parentsExamLoginReminder($schema) {

        $sql_updated = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', ili kuona matokeo ya  mtoto wako katika ShuleSoft. Fungua  https://" . $schema->table_schema . ".shulesoft.co, kisha ingiza username ambayo ni '||p.username||' na password ya kuanzia ni '||p.default_password||'. Kwa msaada zaidi tupigie. Asante', p.phone, 0,0, p.\"parentID\",'parent' FROM " . $schema->table_schema . ".parent p, " . $schema->table_schema . ".setting s where p.\"parentID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"user\"='Parent') and p.status=1 and p.\"parentID\" IN (
SELECT a.parent_id from " . $schema->table_schema . ".student_parents a join " . $schema->table_schema . ".student b on b.student_id=a.student_id   where b.status=1 and a.student_id in (
select \"student_id\" from " . $schema->table_schema . ".student_exams ) )";
        return DB::statement($sql_updated);
    }

    public function usersLoginReminder($schema) {
        $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', je umewahi ingia katika akaunti yako ya ShuleSoft '||upper(s.sname)||'  na kujifunza jinsi inavyoweza kusaidia utendaji kazi wako uwe rahisi na kuboresha taaluma ya Shule ? Kama bado, ni rahis kuanza, kupitia simu yako au computer yako, ingia sehemu ya internet (Google), na kuandika https://" . $schema->table_schema . ".shulesoft.co, kisha ingiza nenotumizi (username) ni '||p.username||' na nenosiri la kuanzia ni '||case when p.default_password is null then 'user123' else p.default_password end||'. Kwa msaada(0655406004) au uongozi wa shule ('||s.phone||'). Siku njema', p.phone, 0,0, p.\"userID\",'user' FROM " . $schema->table_schema . ".user p, " . $schema->table_schema . ".setting s where p.\"userID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"user\" not in ('Teacher','Parent','Student')) and p.status=1";
        return DB::statement($sql);
    }

    public function sendTeachersLoginReminder($schema) {
        $sql = "insert into " . $schema->table_schema . ".sms (body,phone_number,status,type,user_id,\"table\")
select 'Hello '|| p.name|| ', kwa sasa, wastani wa kila mtihani uliosahihisha, mishahara ya kila mwezi (payroll na payslip), na taarifa zote za shule '||upper(s.sname)||'  utazipata katika akaunti yako ya ShuleSoft. Ili Kuingia, fungua sehemu ya internet (Google), na andika https://" . $schema->table_schema . ".shulesoft.co, kisha ingiza nenotumizi (username) lako '||p.username||' na nenosiri(password) lako ni '||case when p.default_password is null then 'teacher123' else p.default_password end||'. Kwa msaada(0655406004) au uongozi wa shule ('||s.phone||'). Karibu', p.phone, 0,0, p.\"teacherID\",'teacher' FROM " . $schema->table_schema . ".teacher p, " . $schema->table_schema . ".setting s where p.\"teacherID\" NOT IN (SELECT user_id from " . $schema->table_schema . ".log where user_id is not null and \"table\"='teacher') and p.status=1";
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
        $datas = DB::connection('biotime')->table('public.iclock_transaction')->where('punch_state', '0')->limit(50)->get();
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                $device = DB::table('api.attendance_devices')->where('serial_number', $data->terminal_sn)->first();
                $employee = DB::table('admin.users')->where('sid', $data->emp_code)->first();
                if (empty($device)) {
                    $device_id = DB::table('api.attendance_devices')->insert(['serial_number' => $data->terminal_sn, 'schema_name' => 'admin']);
                    $device = DB::table('api.attendance_devices')->where('id', $device_id)->first();
                }
                if (!empty($employee)) {
                    $uattendance = DB::table('admin.uattendances')->where('user_id', $employee->id)->whereDate('date', date("Y-m-d", strtotime($data->punch_time)))->first();
                    if (empty($uattendance)) {
                        DB::table('admin.uattendances')->insert([
                            'user_id' => $employee->id,
                            'created_by' => $device->id,
                            'source' => 'api',
                            'timein' => date("Y-m-d H:i:s", strtotime($data->punch_time)),
                            'date' => date("Y-m-d", strtotime($data->punch_time)),
                            'present' => 1
                        ]);
                    } else {
                        $emp_code = "'" . $employee->id . "'";
                        $timeout = DB::connection('biotime')->table('public.iclock_transaction')->where('emp_code', $emp_code)->whereDate('punch_time', date("Y-m-d", strtotime($data->punch_time)))->orderBy('id', 'DESC')->first();
                        !empty($timeout) ? DB::table('admin.uattendances')->where('user_id', $employee->id)->whereDate('date', date("Y-m-d", strtotime($data->punch_time)))->update(['timeout' => date("Y-m-d H:i:s", strtotime($timeout->punch_time)), 'updated_at' => date("Y-m-d H:i:s")]) : '';
                    }
                } else {
                    $user = DB::table('admin.all_users')->where('sid', $data->emp_code)->first();

                    if (!empty($user)) {

                        if ($user->table == 'student') {
                            $attendance = DB::table($user->schema_name . '.sattendances')->where('student_id', $user->id)->whereDate('date', date("Y-m-d", strtotime($data->punch_time)))->first();
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
                            $uattendance = DB::table($user->schema_name . '.uattendances')->where('user_id', $user->id)->where('user_table', $user->table)->whereDate('date', date("Y-m-d", strtotime($data->punch_time)))->first();
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
                    }
                }
                DB::connection('biotime')->table('public.iclock_transaction')->where('id', $data->id)->update(['punch_state' => '1']);
            }
        }
    }

    //Send notification remainder on matured standing orders, ie designation_id = 2  C.O.O
    public function standingOrderRemainder() {
        $controller = new \App\Http\Controllers\Controller();
        $users = \App\Models\User::where('designation_id', 2)->where('status', 1)->get();
        if (!empty($users)) {
            foreach ($users as $user) {
                $standingorders = \App\Models\StandingOrder::whereDate('payment_date', \Carbon\Carbon::today())->get();
                if (!empty($standingorders)) {
                    foreach ($standingorders as $standing) {
                        $message = 'Hello ' . $user->firstname . ' ' . $user->lastname . '.'
                                . chr(10) . 'Remember to check matured standing order from ' . $standing->client->name
                                . chr(10) . 'Thanks.';
                        $controller->send_sms($user->phone, $message, 1);
                        $controller->send_whatsapp_sms($user->phone, $message);
                    }
                }
            }
        }
    }

    // F(x) to send text remainder to keep phone active to school admins
    public function SMSStatusToSchoolsAdmin() {
        // select all schools not keep their app active for the past 24 hours
        $schools = \App\Models\SchoolKeys::where('last_active', '<', \Carbon\Carbon::now()->subDay())->get();
        foreach ($schools as $school) {
            // Select school admin contacts to message to
            $contacts = DB::table($school->schema_name . '.user')->where('usertype', 'Admin')->get();
            if (count($contacts) > 0) {
                foreach ($contacts as $contact) {
                    $message = 'Ndugu ' . $contact->name . '.'
                            . chr(10) . 'Ili kuepusha kufeli au kutokufika kwa SMS kwa wazazi, hakikisha Simu inayotumika kutuma SMS kutoka shule kwa kutumia App ya SMS, inakuwa hewani na internet muda wote.Asante '
                            . chr(10) . 'Asante';
                    $controller = new \App\Http\Controllers\Controller();
                    $controller->send_whatsapp_sms($contact->phone, $message);
                    $controller->send_sms($contact->phone, $message, 1);
                }
            }
        }
    }

    // function to remaind HRO on employees contracts end 
    public function HRContractRemainders() {
        $users = DB::select('select * from admin.users where contract_end_date - CURRENT_DATE = 30 and status = 1 and role_id <> 7');
        $hr_officer = \App\Models\User::where(['role_id' => 16, 'status' => 1])->first();
        if (!empty($users)) {
            foreach ($users as $user) {
                if ($user->contract_end_date < date('Y-m-d')) {
                    $message = 'Hello ' . $hr_officer->firstname . ' ' . $hr_officer->lastname . '.'
                            . chr(10) . 'Employment contract of ' . $user->firstname . ' ' . $user->lastname . ' has already  expired on ' . date('d-m-Y', strtotime($user->contract_end_date)) . '.'
                            . chr(10) . 'Thanks.';
                    $controller = new \App\Http\Controllers\Controller();
                    $controller->send_whatsapp_sms($hr_officer->phone, $message);
                    $controller->send_sms($hr_officer->phone, $message, 1);
                    $controller->send_email($hr_officer->email, 'Employee Contract', $message);
                } else {
                    $message = 'Hello HR,' . $hr_officer->firstname . ' ' . $hr_officer->lastname . '.'
                            . chr(10) . 'Employment contract of ' . $user->firstname . ' ' . $user->lastname . ' expected to expire on  ' . date('d-m-Y', strtotime($user->contract_end_date)) . '.'
                            . chr(10) . 'Thanks.';
                    $controller = new \App\Http\Controllers\Controller();
                    $controller->send_whatsapp_sms($hr_officer->phone, $message);
                    $controller->send_sms($hr_officer->phone, $message, 1);
                    $controller->send_email($hr_officer->email, 'Employee Contract', $message);
                }
            }
        }
    }

    // function to remainder HR about annual leave of employees
    // To do more improvement to include employemet status ie intern,probation etc
    public function HRLeaveRemainders() {
        $annual = DB::select("select user_id, case when (end_date is null) then joining_date + interval '1 year' else end_date + interval '1 year' end AS annual_date
         from admin.annual_leave");
        $ids = array();
        foreach ($annual as $value) {
            $ids[] = $value->user_id;
        }

        foreach ($annual as $value) {
            if (!is_null($value->annual_date) && date('Y-m-d') == date('Y-m-d', strtotime($value->annual_date . ' - 30 days'))) {
                $users = \App\Models\User::whereIn('id', $ids)->where('status', 1)->whereNotIn('role_id', array(7, 15))->get();
                $hr_officer = \App\Models\User::where(['role_id' => 16, 'status' => 1])->first();
                foreach ($users as $user) {
                    $message = 'Hello '
                            . chr(10) . 'This is the remainder of : ' . $user->firstname . ' ' . $user->lastname . ' is expected to start the annual leave on'
                            . chr(10) . date('d-m-Y', strtotime($value->annual_date . ' + 1 days'))
                            . chr(10) . 'Thanks.';
                    $controller = new \App\Http\Controllers\Controller();
                    $controller->send_whatsapp_sms($hr_officer->phone, $message);
                    $controller->send_sms($hr_officer->phone, $message, 1);
                    $controller->send_email($hr_officer->email, 'Employee Annual leave', $message);
                }
            }
        }
    }

    // function to remaind school tasks created by users
    public function setTaskRemainder() {
        $tasks = \App\Models\Task::where('remainder', 0)->where('remainder_date', '=', date('Y-m-d'))->get();
        $controller = new \App\Http\Controllers\Controller();
        if (count($tasks)) {
            foreach ($tasks as $task) {
                $message = 'Hello ' . $task->user->name . '.'
                        . chr(10) . 'This is the remainder of : ' . strip_tags($task->activity) . '.'
                        . chr(10) . 'Type: ' . $task->taskType->name . '.'
                        . chr(10) . 'From ' . $task->client->name . ''
                        . chr(10) . 'You created at : ' . date('d-m-Y', strtotime($task->created_at))
                        . chr(10) . 'Thanks.';
                $controller->send_whatsapp_sms($task->user->phone, $message);
                $controller->send_sms($task->user->phone, $message);

                if ($task->taskUsers()->count() > 0) {
                    foreach ($task->taskUsers()->get() as $task_user) {
                        if ($task_user->user_id != $task->user->id) {
                            $user = \App\Models\User::find($task_user->user_id);
                            $msg = 'Hello ' . $user->firstname . ' ' . $user->lastname . '.'
                                    . chr(10) . 'This is the remainder of a task allocated to you'
                                    . chr(10) . 'Task: ' . strip_tags($task->activity) . '.'
                                    . chr(10) . 'Type: ' . $task->taskType->name . '.'
                                    . chr(10) . 'From ' . $task->client->name . ''
                                    . chr(10) . 'Deadline: ' . date('d-m-Y', strtotime($task->start_date)) . '.'
                                    . chr(10) . 'By: ' . $task->user->name . '.'
                                    . chr(10) . 'Thanks.';
                            $controller->send_whatsapp_sms($user->phone, $msg);
                            $controller->send_sms($user->phone, $msg);
                        }
                    }
                }
                \App\Models\Task::where('id', $task->id)->update(['remainder' => 1]);
            }
        }
    }

    // function to refresh materialized views twice per day
    public function RefreshMaterializedView() {
        DB::statement('select from admin.refresh_materialized_views()');
    }

    public function weeklyAccountsReports() {
        $schemas = (new \App\Http\Controllers\Software())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin'))) {
                $directors = DB::select("select * from admin.all_users where usertype ilike '%director%' and schema_name = '{$schema->table_schema}'");
                $weekly_amount = \collect(DB::select("select COALESCE(sum(amount),0) as sum from " . $schema->table_schema . " . total_revenues where date_trunc('week', date) = date_trunc('week', current_date)"))->first();
                $weekly_expenditure = \collect(DB::select("select COALESCE(sum(amount),0) as sum from " . $schema->table_schema . " . expense where date_trunc('week', date) = date_trunc('week', current_date)"))->first();
                $total_revenues = $weekly_amount->sum;
                $total_expenditure = $weekly_expenditure->sum;

                if (!empty($directors)) {
                    foreach ($directors as $director) {
                        $message = 'Dear sir/madam'
                                . chr(10) . 'The following is account report for your school this week starts at ' . date('F, d Y', strtotime('monday this week'))
                                . chr(10) . 'Total collection Tsh ' . money($total_revenues) . ''
                                . chr(10) . 'Total expenditure Tsh ' . money($total_expenditure) . ''
                                . chr(10) . 'Thanks.';
                        $controller = new \App\Http\Controllers\Controller();
                        $controller->send_whatsapp_sms($director->phone, $message);
                        $controller->send_sms($director->phone, $message, 1);
                    }
                }
            }
        }
    }

    public function monthlyAccountsReports() {
        $schemas = (new \App\Http\Controllers\Software())->loadSchema();
        foreach ($schemas as $schema) {
            if (!in_array($schema->table_schema, array('public', 'api', 'admin'))) {
                $directors = DB::select("select * from admin.all_users where usertype ilike '%director%' and schema_name = '{$schema->table_schema}'");

                $monthly_amount = \collect(DB::select("select COALESCE(sum(amount),0) as sum from " . $schema->table_schema . " . total_revenues where date_trunc('month', date) = date_trunc('month', current_date)"))->first();
                $monthly_expenditure = \collect(DB::select("select COALESCE(sum(amount),0) as sum from " . $schema->table_schema . " . expense where date_trunc('month', date) = date_trunc('month', current_date)"))->first();
                $total_revenues = $monthly_amount->sum;
                $total_expenditure = $monthly_expenditure->sum;

                if (!empty($directors)) {
                    foreach ($directors as $director) {
                        $message = 'Dear sir/madam'
                                . chr(10) . 'Kindly find the reports on the fees for your school this month starts at ' . date('m-01-Y')
                                . chr(10) . 'Total collection Tsh ' . money($total_revenues) . ''
                                . chr(10) . 'Total expenditure Tsh ' . money($total_expenditure) . ''
                                . chr(10) . 'Thanks.';
                        $controller = new \App\Http\Controllers\Controller();
                        $controller->send_whatsapp_sms($director->phone, $message);
                        $controller->send_sms($director->phone, $message, 1);
                    }
                }
            }
        }
    }

    public function findMissingPayments() {
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

//    public function karibuSMS() {
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "http://www.karibusms.com/check_pending");
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//        $data = curl_exec($ch);
//    }

    public function pushRevInvoice($invoice) {
        $token = $this->getToken($invoice);
        if (strlen($token) > 4) {
            $fields = array(
                "reference" => trim($invoice->reference),
                "student_name" => isset($invoice->payer_name) ? $invoice->payer_name : '',
                "student_id" => $invoice->user_id,
                "amount" => $invoice->amount,
                "allow_partial" => "TRUE",
                "type" => ucfirst($invoice->schema_name) . ' payment for Student other Transaction',
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

    public function syncData() {

        $limit = 3;
        for ($i = 0; $i < 250; $i++) {

            //  echo $merge_sql="select * from admin.merge_limit_tables('public',{$i},{$limit})";
            //  $s= DB::statement($merge_sql);
            //print_r($s);
            //DB::statement("select * from admin.refresh_materialized_views_limit({$i},{$limit})");
            $sync_sql_ = "select * from admin.sync_data_to_shulesoft({$i},{$limit})";
            DB::statement($sync_sql_);
            echo 'success round=' . $i . chr(10);
            sleep(0.5);
            $i += $limit - 1;
        }

        $url = 'http://75.119.140.177/shulesoft_staging/api/accountsync';

        $ch = curl_init();
// Set the url, number of POST vars, POST data
        $fields = [];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/x-www-form-urlencoded'
        ));

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        print_r($result);
    }

    // protected function commands()
    // {
    //     $this->load(__DIR__.'/Commands');
    //     require base_path('routes/console.php');
    // }
}
