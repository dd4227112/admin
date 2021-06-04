<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ModuleTask;
use DB;

class Background extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tag = 'sms') {
        //
        return $tag == 'sms' ?
                $this->dispatch((new \App\Jobs\PushSMS())) :
                $this->dispatch((new \App\Jobs\PushEmail()));
    }

    // public function sendSms() {
    //     $messages = DB::select('select * from public.all_sms limit 15');
    //     if (!empty($messages)) {
    //         foreach ($messages as $sms) {
    //             define('API_KEY', $sms->api_key);
    //             define('API_SECRET', $sms->api_secret);

    //             $karibusms = new \karibusms();
    //             $karibusms->set_name(strtoupper($sms->schema_name));
    //             $karibusms->karibuSMSpro = $sms->type;
    //             $result = (object) json_decode($karibusms->send_sms($sms->phone_number, $sms->body));
    //             if ($result->success == 1) {
    //                 DB::update('update ' . $sms->schema_name . '.sms set status=1 WHERE sms_id=' . $sms->sms_id);
    //             } else {
    //                 DB::update('update ' . $sms->schema_name . '.sms set status=0 WHERE sms_id=' . $sms->sms_id);
    //             }
    //         }
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function updateInvoice() {
        $invoices = DB::select('select * from api.invoices where sync=1 and amount >0 and payment_integrated=1');
        if (count($invoices) > 0) {
            foreach ($invoices as $invoice) {
                $token = $this->getToken($invoice);
                if (strlen($token) > 4) {
                    $fields = array(
                        "reference" => trim($invoice->reference),
                        "student_name" => $invoice->student_name,
                        "student_id" => $invoice->student_id,
                        "amount" => $invoice->amount,
                        "type" => $this->getFeeNames($invoice->id, $invoice->schema_name),
                        "code" => "10",
                        "callback_url" => "http://51.91.251.252:8081/api/init",
                        "token" => $token
                    );
                    // $push_status = $invoice->status == 2 ? 'invoice_update' : 'invoice_submission';
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
                    $curl = $this->curlServer($fields, $url);
                    $result = json_decode($curl);
                    if (($result->status == 1 && strtolower($result->description) == 'success') || $result->description == 'Duplicate Invoice Number') {
//update invoice no
                        DB::table($invoice->schema_name . '.invoices')
                                ->where('reference', $invoice->reference)->update(['sync' => 1, 'return_message' => $curl, 'push_status' => $push_status]);
                    }
                    DB::table('api.requests')->insert(['return' => $curl, 'content' => json_encode($fields)]);
                }
            }
        }
    }

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
                $user = '';
                $pass = '';
            }
        }
        $request = $this->curlServer([
            'username' => $user,
            'password' => $pass
                ], $url);
        $obj = json_decode($request);
        //DB::table('api.requests')->insert(['return' => json_encode($obj), 'content' => json_encode($request)]);
        if (isset($obj) && is_object($obj) && isset($obj->status) && $obj->status == 1) {
            return $obj->token;
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

    public function curlServer($fields, $url, $type = null) {
// Open connection
        $ch = curl_init();
// Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/x-www-form-urlencoded'
        ));

        curl_setopt($ch, CURLOPT_POST, TRUE);
        $data = $type == null ? json_encode($fields) : $fields;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /*     * This sql exclude school with defined academic year. If a school has got a primary and nursery level and only one level has created new academic year, this query will skip creation of new acdemic year
     * 
     */

    public function createAcademicYear() {
        DB::select("select * from admin.join_all('academic_year','id,name,class_level_id,created_at,updated_at,start_date,end_date')");
        $years = DB::select('select distinct a.class_level_id,a."schema_name" from admin.all_academic_year a join admin.all_classlevel b on 
           (a.class_level_id =b.classlevel_id and a."schema_name"=b."schema_name")
           where b.school_level_id in (1,2,3) and a."schema_name" not in (select "schema_name" from admin.all_academic_year where name=\'' . date('Y') . '\') order by a."schema_name"');
        foreach ($years as $year) {
            $academic_year_id = DB::table($year->schema_name . '.academic_year')->insertGetId(array('name' => date('Y'), 'class_level_id' => $year->class_level_id, 'start_date' => date('Y-01-01'), 'end_date' => date('Y-12-31')));

            DB::table($year->schema_name . '.semester')->insert(array('name' => 'Term One', 'class_level_id' => $year->class_level_id, 'academic_year_id' => $academic_year_id, 'start_date' => date('Y-01-01'), 'end_date' => date('Y-06-30'), 'study_days' => 92));
            DB::table($year->schema_name . '.semester')->insert(array('name' => 'Term Two', 'class_level_id' => $year->class_level_id, 'academic_year_id' => $academic_year_id, 'start_date' => date('Y-07-01'), 'end_date' => date('Y-12-31'), 'study_days' => 92));
        }
    }

    public function officeDailyReport() {
        $users = \DB::select("select * from admin.users where status=1 and email not like '%nmb%' ");
        ;
        foreach ($users as $user) {
            $tasks = DB::select("select b.name, count(a.*) from admin.tasks a join admin.task_types b on b.id=a.task_type_id where a.created_at::date=CURRENT_DATE AND user_id=" . $user->id . " group by b.name");
            $tr = '';
            foreach ($tasks as $task) {
                $tr .= '<tr><td>' . $task->name . '</td><td>' . $task->count . '</td></tr>';
            }
            $message = ''
                    . '<h2>Todays Report</h2>'
                    . '<p>This report specify what you have done today and it is used by management to evaluate your performance and contribution to the company</p>'
                    . '<table><thead><tr><th>Activity Name</th><th>Number of Activities</th></tr></thead><tbody>' . $tr . '</tbody></table>';
            DB::table('public.email')->insert([
                'subject' => date('Y M d') . ' Report',
                'body' => $message,
                'email' => $user->email
            ]);
        }
    }

    public function tech_task() {
        // $data1          = json_decode(file_get_contents(base_path() . '/task.json'));
        $data1 = request()->all();

        $repo = isset($data1['repository']['full_name']) ? $data1['repository']['full_name'] : '';
        $user = isset($data1['push']['changes'][0]['commits'][0]) ? $data1['push']['changes'][0]['commits'][0]['author']['user']['display_name'] : '';
        $commit_message = isset($data1['push']['changes'][0]['commits'][0]) ? $data1['push']['changes'][0]['commits'][0]['message'] : '';
        $commit_message_in_words = explode(' ', trim($commit_message));
        $activity_type = strtolower($commit_message_in_words[0]);
        $module_of_activity = strtolower($commit_message_in_words[1]);

        // after getting message then taking Id for identifying type
        // firstly getting activity type from database

        if (DB::table('admin.task_types')->whereRaw('LOWER(name) LIKE ?', ['%' . ($activity_type) . '%'])->count()) {
            $id = DB::table('admin.task_types')->whereRaw('LOWER(name) LIKE ?', ['%' . ($activity_type) . '%'])->first();
            $task_id = $id->id;
        } else {
            $task_id = 27;
            #sending message to the Commiter that the entered activity type is not correct
        }

        if (DB::table('admin.modules')->whereRaw('LOWER(name) LIKE ?', ['%' . ($module_of_activity) . '%'])->count()) {
            $id = DB::table('admin.modules')->whereRaw('LOWER(name) LIKE ?', ['%' . ($module_of_activity) . '%'])->first();
            $module_id = $id->id;
        } else {
            $module_id = '';
        }

        #getting a user who push
        if (DB::table('admin.users')->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($user) . '%'])->count()) {
            $actor = DB::table('admin.users')->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($user) . '%'])->first();
            $user_id = $actor->id;
        }
        #data to be sent to the database
        $data = [
            'user_id' => $user_id,
            'activity' => $commit_message,
            'date' => date('Y-m-d'),
            'start_date' => date("Y-m-d H:i:s", strtotime("-1 hours")),
            'end_date' => date("Y-m-d H:i:s"),
            'to_user_id' => $user_id,
            'task_type_id' => $task_id,
            'status' => 'complete',
            'time' => '1',
        ];

        // Then pushing to the database(Task) from Repository after push
        $send_task = \App\Models\Task::create($data);
        // Then adding entry to module_tasks table
        $module_tasks = new ModuleTask();
        $module_tasks->module_id = $module_id;
        $module_tasks->task_id = $send_task->id;
        $module_tasks->save();


        // Then pushing to the database(Table tasks_user) from Repository after push
        $send_task_to_user_task = DB::table('tasks_users')->insert(
                [
                    'user_id' => $user_id,
                    'task_id' => $send_task->id
                ]
        );

        if ($send_task_to_user_task) {
            print("task has been saved to the database");
        } else {
            print("sorry an error occured failed to save ");
        }
    }

    public function createEpayment() {
        $order_id = request()->segment(3);
        $total = request()->segment(4);
        if ((int) $total > 0) {
            $check = \App\Models\Invoice::where('order_id', $order_id)->first();
            if ($check) {
                $invoice = $check;
            } else {
                $data = [
                    'order_id' => $order_id,
                    'amount' => $total,
                    'user_id' => 2,
                    'sid' => 4343,
                    "client_id" => 79,
                    'source' => 'carryshop',
                    'status' => 0,
                    'schema_name' => 'carryshop',
                    'methods' => 'selcom'
                ];
                $invoice = \App\Models\Invoice::create($data);
                \App\Models\InvoiceFee::create(['invoice_id' => $invoice->id, 'amount' => $total, 'project_id' => 2, 'item_name' => 'ShuleSoft Service Fee For ', 'quantity' => 1, 'unit_price' => 1]);
            }
        } else {
            echo 'Invalid Amount ' . $total;
            exit;
        }
        $booking = $invoice;
        if ($booking) {
            if (strlen($booking->token) < 4) {
                $account = new \App\Http\Controllers\Account();
                $account->createSelcomControlNumber($invoice->id);
            }
            $paid = 0;
            if ($booking->payments()->sum('amount') == $booking->invoiceFees()->sum('amount')) {
                $paid = 1;
            }
            $am = $invoice->invoiceFees()->sum('amount');
            $paid = $invoice->payments()->sum('amount');
            $unpaid = $am - $paid;

            $balance = $booking->payments()->sum('amount');
            $page = 'api_pay';
            return view('account.invoice.' . $page, compact('booking', 'balance', 'paid', 'invoice', 'unpaid'));
        } else {
            return redirect()->back()->with('warning', 'This Invoice Number Not Defined Properly');
        }
    }

    public function epayment() {
        $invoice_id = request()->segment(3);
        $booking = $invoice = \App\Models\Invoice::find($invoice_id);
        if ($booking) {
            if (strlen($booking->token) < 4) {
                $account = new \App\Http\Controllers\Account();
                $account->createSelcomControlNumber($invoice_id);
            }
            $paid = 0;
            if ($booking->payments()->sum('amount') == $booking->invoiceFees()->sum('amount')) {
                $paid = 1;
            }
            $am = $invoice->invoiceFees()->sum('amount');
            $paid = $invoice->payments()->sum('amount');
            $unpaid = $am - $paid;

            $balance = $booking->payments()->sum('amount');
            $page = 'pay';
            return view('account.invoice.' . $page, compact('booking', 'balance', 'paid', 'invoice', 'unpaid'));
        } else {
            return redirect()->back()->with('warning', 'This Invoice Number Not Defined Properly');
        }
    }

    //Notify all admin about monthly reports
    public function schoolMonthlyReport() {
        DB::select('REFRESH MATERIALIZED VIEW CONCURRENTLY public.all_users');
        $users = DB::select("select * from admin.all_users where lower(usertype)='admin' and status=1");
        $key_id = DB::table('public.sms_keys')->first()->id;
        foreach ($users as $user) {
            $message = 'Dear Sir/Madam '
                    . 'Kindly find ' . number_to_words(date('m')) . ' Month Report from 1st Jan to ' . date('d M Y') . ' and analyse your school performance '
                    . 'specifically on Students/parents/teachers Registered this Year and per Month, Amount of Fee collected Total and on Each month,'
                    . 'Academic performances per classes, subjects and teachers, Best students/teachers etc.'
                    . 'Open this link to open https://' . $user->schema_name . '.shulesoft.com/report/quarter/' . $user->sid . '  . Dont share this message. Thank you';
            DB::table('public.sms')->insert([
                'body' => $message,
                'phone_number' => $user->phone,
                'type' => 0,
                'sms_keys_id' => $key_id
            ]);
            if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email) && !in_array($user->email, ['inetscompany@gmail.com'])) {

                $subject = 'ShuleSoft ' . number_to_words(date('m')) . ' Months Report';
                $obj = array('body' => $message, 'subject' => $subject, 'email' => $user->email);

                DB::table($user->schema_name . '.email')->insert($obj);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function associate() {
        $id = (int) request()->segment(3) == 0 ? Auth::user()->id : request()->segment(3);
        $this->data['user'] = \App\Models\User::find($id);
        return view('users.associate', $this->data);
    }

    public function registerApplicant() {
        $applicant_id = decrypt(request()->segment(3));
        $applicant = DB::table('admin.applicants')->where('id', $applicant_id)->first();
        if ($applicant) {
            //register user in demo account
            //build data to upload
            if (DB::table('public.user')->where('email', $applicant->email)->first()) {
                //user exists, set to 1 then send email
                DB::table('public.user')->where('email', $applicant->email)->update(['status' => 1]);
                return $this->sendApplicantEmail(DB::table('public.user')->where('email', $applicant->email)->first());
            }
            $pass = rand(1, 999) . substr(str_shuffle('abcdefghkmnpl'), 0, 3);
            $password = bcrypt($pass);
            DB::table('public.user')->insert(array('username' => str_replace(" ", NULL, $applicant->phone),
                'salary' => (float) 0, 'sex' => $applicant->gender, 'name' => $applicant->name, 'email' => $applicant->email, 'phone' => $applicant->phone,
                'password' => $password, 'default_password' => $pass, 'status' => 1,
                'photo' => 'defualt.png', 'dob' => date('Y-m-d', strtotime($applicant->dob)),
                'usertype' => 'Admin', 'jod' => date('Y-m-d')
            ));
            $this->registerInAdmin($applicant, $password);
            return $this->sendApplicantEmail(DB::table('public.user')->where('email', $applicant->email)->first());
            //send confirmation email and send invite email for academy learning
        } else {
            die('Wrong url supplied, this user does not exists');
        }
    }

    public function sendApplicantEmail($applicant) {
        $message = view('email.associate_confirm');
        $patterns = array(
            '/#name/i', '/#username/i', '/#password/i',
        );
        $replacements = array(
            $applicant->name, $applicant->username, $applicant->default_password
        );
        //send sms
        $sms = preg_replace($patterns, $replacements, $message);
        $new_user_message = 'Hi ' . $applicant->name . ', Your accounts ( in https://demo.shulesoft.com, https://academy.shulesoft.com) '
                . 'has been created successfully with username: ' . $applicant->username . ' and password: ' . $applicant->default_password . ' .Check your email for detailed information. Thanks ';
        $this->send_sms($applicant->phone, $new_user_message);
        $this->send_email($applicant->email, 'Success: ShuleSoft Account Registration', $sms);
        die('Success: Your Account has been created, kindly wait for the confirmation email with details on how to get started. Thanks');
    }

    public function InviteApplicants() {
        $applicants = DB::select('select * from admin.applicants where id not in (select applicant_id from admin.users where applicant_id is not null)');
        foreach ($applicants as $applicant) {

            $message = view('email.associate');
            $patterns = array(
                '/#name/i', '/#link/i',
            );
            $url = 'https://admin.shulesoft.com/background/registerApplicant/' . encrypt($applicant->id);
            $replacements = array(
                $applicant->name, $url
            );
            //send sms
            $sms = preg_replace($patterns, $replacements, $message);
            $new_user_message = 'Hello ' . $applicant->name . ' '
                    . 'You are kindly invited to Join ShuleSoft Associate Program. Our Associates will be directly involved to provide training, data entry and configuration '
                    . 'to ALL schools (600+) and get paid per task done but also exposed to '
                    . 'schools that are looking for candidates who knows ShuleSoft. Click this link to join (' . $this->shortenUrl($url) . ') or visit our website (www.shulesoft.com) to learn more. Thanks';
            $this->send_sms($applicant->phone, $new_user_message);
            $this->send_email($applicant->email, 'We are looking for ShuleSoft Regional and Local Associates', $sms);
            echo 'Email and SMS sent to ' . $applicant->name . '<br/>';
        }
    }

    public function registerInAdmin($applicant, $password) {
        return DB::table('admin.users')->insert(array('firstname' => $applicant->name,
                    'sex' => $applicant->gender, 'email' => $applicant->email, 'phone' => $applicant->phone, 'name' => $applicant->name,
                    'password' => $password, 'status' => 1,
                    'applicant_id' => $applicant->id
        ));
    }

    public function shortenUrl($url) {
        $key = '21ac1db212ce1bd8fb357c6f4b0edb2a2b18b';
        $json = file_get_contents('https://cutt.ly/api/api.php?key=' . $key . '&short=' . $url);
        $data = json_decode($json, true);
        return $short_url = $data["url"]["shortLink"];
    }

    public function sync() {
        $software = new \App\Http\Controllers\Software();
        $schemas = $software->loadSchema();
        $schema_number = 1;
        foreach ($schemas as $schema) {

            //check if schema exists or create
            $sql = "SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE table_schema= '" . $schema->table_schema . "' limit 1";
            $check_schema = \collect(DB::connection('live')->select($sql))->first();
            if (empty($check_schema)) {
                DB::connection('live')->statement("create schema if not exists " . $schema->table_schema);
                echo 'Schema ' . $schema->table_schema . ' Created Successfully <br/>';
            }

            //get tables on that schema
            $tables = $software->loadTables($schema->table_schema);

            //loop through tables and push one by one
            //
           foreach ($tables as $table) {

                //check if table exists in live envir
                $check_table = \collect(DB::connection('live')->select("SELECT table_name, column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE  is_updatable='YES' AND "
                                . " table_schema='" . $schema->table_schema . "' AND table_name='" . $table . "'"))->first();

                $object_array = (array) DB::table($schema->table_schema . '.' . $table)->first();

                if (!empty($check_table)) {
                    echo 'Table  ' . $table . ' exists, now importing data in ' . $schema->table_schema . '.' . $table . ' schema Successfully <br/>';

                    !empty($object_array) ? $this->insertIntoLive($schema->table_schema, $table) : '';
                } else {
                    //this table does not exists, so sync this table
                    echo 'Table ' . $schema->table_schema . '. ' . $table . ' does not exists, try to create new table now <br/>';
                    $software->syncTable($table, $schema->table_schema, 'live');
                    echo 'Table ' . $schema->table_schema . '. ' . $table . ' created successfully <br/>';
                    !empty($object_array) ? $this->insertIntoLive($schema->table_schema, $table) : '';
                    echo 'Table data imported after creating ' . $schema->table_schema . '. ' . $table . ' , success<br/>';
                }
            }
            echo 'Finishing Schema No ' . $schema_number . '<br/>';
            $schema_number++;
        }
        echo 'All schema (' . $schema_number . ') has been proceesed successfully';
    }

    public function insertIntoLive($schema_table_schema, $table) {
//        $table_sql = "SELECT column_default,data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='" . $schema_table_schema . "' AND table_name='" . $table . "' AND column_name='created_at' limit 1";
//        $local = \collect(DB::select($table_sql))->first();
//        if (empty($local)) {
//            DB::statement('alter table ' . $schema_table_schema . '.' . $table . ' add column if not exists created_at timestamp without time zone default now()');
//            DB::connection('live')->statement('alter table ' . $schema_table_schema . '.' . $table . ' add column if not exists created_at timestamp without time zone default now()');
//        }
//        $check = DB::connection('live')->table($schema_table_schema . '.' . $table)->orderBy('created_at', 'desc')->first();
//        if (!empty($check)) {
        if (!in_array($table, ['log', 'requests'])) {
            $object_data = DB::table($schema_table_schema . '.' . $table)->get();
            if (count($object_data) > 0) {
                $ob = [];
                foreach ($object_data as $data) {
                    //array_push($ob, (array) $data);
                    DB::connection('live')->table($schema_table_schema . '.' . $table)->insert((array) $data);
                    echo 'data inserted for table ' . $table . '<br/>';
                }
            }
        }
        // }
    }

  

    public function searchDistrict() {
        $region_id = request('region_id');
        $districts = \App\Models\District::where('region_id', $region_id)->get();

        $select = '<select  class="form-control" id="search_district">';
        foreach ($districts as $district) {
            $select .= '<option value="' . $district->id . '">' . $district->name . '</option>';
        }
        $select .= '</select>';
        echo $select;
    }

    public function searchWard() {
        $region_id = request('district_id');
        $wards = \App\Models\Ward::where('district_id', $region_id)->get();

        $select = '';
        foreach ($wards as $ward) {
            $select .= '<input class="border-checkbox ward_lists" type="checkbox" name="wards[]" id="checkbox' . $ward->id . '" value="' . $ward->id . '">
                                                <label class="border-checkbox-label" for="checkbox1">' . $ward->name . ' </label>
                                            ';
        }
        $select .= '';
        echo $select;
    }

    function allocateSchool() {
        $user_id = request('user_id');
        $wards = request('wards');
        foreach ($wards as $ward) {
            DB::table('users_schools_wards')->insert(['user_id' => $user_id, 'ward_id' => $ward]);
        }
        return redirect()->back()->with('success', 'success');
    }

    public function removeUserSchool() {
        $user_id = request()->segment(3);
        $ward_id = request()->segment(4);
        DB::table('users_schools_wards')->where('user_id', $user_id)->where('ward_id', $ward_id)->delete();
        return redirect()->back()->with('success', 'success');
    }

}
