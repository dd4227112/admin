<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Install extends Controller {

    /**
     * -----------------------------------------
     * 
     * ******* Address****************
     * INETS COMPANY LIMITED
     * P.O BOX 32258, DAR ES SALAAM
     * TANZANIA
     * 
     * 
     * *******Office Location *********
     * 11th block, Bima Road, Mikocheni B, Kinondoni, Dar es salaam
     * 
     * 
     * ********Contacts***************
     * Email: <info@inetstz.com>
     * Website: <www.inetstz.com>
     * Mobile: <+255 655 406 004>
     * Tel:    <+255 22 278 0228>
     * -----------------------------------------
     */
    private $dbfile;

  
    public function __construct() {
        $this->middleware('auth');

        /**
         * This module will be upgraded as follows
          1. during installation, school exam format will be pre defined for admin to choose (NECTA, IGSE etc)
          2. if admin choose NECTA, system will ask user to choose class levels for NECTA available which will either be (nursary, primary, o-level and a-level). if user chooses either one or all of those levels,
          system will automatically install class levels available in such school and specify academic year names. If user choose A-Level, system will prompt user to tick combinations available
          3. after installing class level, system will install classes available (pre defined for each level, eg we know in tanzania, o-level will have form one up to form four, so system will install that)
          4. after installing all classes depending on the levels available, system will install all subjects as available in ordinary levels. For simplicity, admin will just choose which subjects do that school study and skip the rest. after that, system will install everything including subject codes and their standards, if they are option or core, included in division or not etc
          5. after that, system will install class level grades (based on NECTA standards)
          6
         */
        $this->dbfile = 'app/config/development/db.txt';
        //$this->checkInstaller();
//	$this->load->helper('file');
//	if ($this->config->item('installed') != 'no') {
//	    show_404();
//	}
    }

    public function checkInstaller() {
        $dbfile = $this->dbfile;
        if (is_file($dbfile)) {
            $content = explode(',', file_get_contents($dbfile));
            if (in_array(str_replace('.', '', set_schema_name()), $content) && uri_string() == 'install/newschool') {
                return redirect(base_url());
            }
        }
    }

    public function newschool() {
        return $this->index();
    }

    function index() {
        return view('install.index');
    }

    public function curlPrivate($fields, $url = null) {
        // Open connection
        $url = 'http://51.77.212.234:8081/api/payment';
        $ch = curl_init();
// Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/x-www-form-urlencoded'
        ));

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function payment() {
        $schema = str_replace('.', NULL, set_schema_name());
        $client = DB::table('admin.clients')->where('username', $schema)->first();

        $check_booking = DB::table('admin.invoices')->where('client_id', $client->id)->first();
        if (!empty($check_booking)) {
            //check if already paid
            $paid = DB::table('admin.payments')->where('invoice_id', $check_booking->id)->first();
            if (!empty($paid)) {
                return $this->database();
            }
            $booking = $check_booking;
        } else {
            $order_id = $client->id . time();

            $total_price = (int) $client->estimated_students < 100 ? 100000 : $client->estimated_students * 1000;

            $order = array("order_id" => $order_id, "amount" => $total_price,
                'buyer_name' => $client->name, 'buyer_phone' => $client->phone, 'end_point' => '/checkout/create-order', 'action' => 'createOrder', 'client_id' => $client->id, 'source' => $client->id);
            $this->curlPrivate($order);
            $booking = DB::table('admin.invoices')->where('order_id', $order_id)->first();
        }

        return view('install.pay', compact('booking'));
    }

    function trial() {
        $trial = request('special_trial_code');
        $check = DB::table('admin.clients')->where('code', $trial)->first();
        if (!empty($check)) {
            //validated
            //return $this->database();
            return redirect('install/database/1');
        } else {
            return redirect()->back()->with('warning', 'Wrong code supplied');
        }
    }

    function database() {
        $schema = request()->segment(3);

        if (!preg_match('/www/', $schema) || !preg_match('/website/', $schema)) {
            $status = DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE lower(table_schema)='" . strtolower($schema) . "'");
            if (empty($status)) {
                DB::statement("select public.clone_schema('shulesoft','" . $schema . "',false,false)");
                DB::statement("select admin.create_admin_views()");
                return redirect('install/site/'.$schema);
            }
        }
    }

    public function createFees() {
        DB::table($schema.'.fees')->insert([
            'name' => 'Transport',
            'id' => 1000
        ]);
        DB::table($schema.'.fees')->insert([
            'name' => 'School Fees'
        ]);
        DB::table($schema.'.fees')->insert([
            'name' => 'Hostel',
            'id' => 2000
        ]);
    }

    function validate_settings() {
        return $this->validate(request(), [
                    'name' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'currency_code' => 'required',
                    'currency_symbol' => 'required',
                    'sname' => 'required',
                    'username' => 'required',
                    'password' => 'required'
        ]);
    }

    function site() {
        $set = DB::table('setting')->first();
        $this->data['setting'] = !empty($set) ? $set : array();
        $schema = request()->segment(3);
        
        $this->data['client'] = DB::table('admin.clients')->where('username', $schema)->first();
        $schema = $this->data['client']->username;
        if(!empty($this->data['client'])){
            $password = ucfirst($schema . date('Y'));

            //$this->validate_settings();
            $data = request()->except('password', 'classlevel', '_token');

            $school = DB::table('admin.client_schools')->where('client_id', $this->data['client']->id)->first();
            $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();
            
            $account_manager_id = 20;
            $sales_manager_id = 20;
            $message_body = 'Hello ' . request("adminname") . '. ShuleSoft has been successfully installed.  You have been added as Admin in ' . request("sname") . ' ShuleSoft System. Login here at ' . set_schema_name() . '.shulesoft.com . Default Username: ' . request("username") . ' and password=' . request("password");
            $school_id = $school->school_id;

                $class_levels = DB::table('admin.school_levels')->where('client_id', $this->data['client']->id)->pluck('name');
                $school_contact = DB::table('admin.school_contacts')->where('school_id', $school_id)->first();

                $message_body = 'Hello ' . $school_contact->name . '. ShuleSoft has been successfully installed.  You have been added as Admin in ' . $this->data['client']->name . ' ShuleSoft System. Login here at ' . $this->data['client']->username . '.shulesoft.com . Default username: ' . $this->data['client']->username . ' and password: ' . $password;
                // dd($this->data['client']); exit;

                $data = array(
                    'currency_code' => 'TZS',
                    'currency_symbol' => 'Tsh.',
                    'sname' => $this->data['client']->name,
                    'phone' => $this->data['client']->phone,
                    'email' => $this->data['client']->email,
                    'school_format' => 'NECTA'
                );

                $derived = array(
                'password' => bcrypt($password),
                'usertype' => 'Admin',
                'username' => $schema, 'name' => $schema,
                'school_id' => $school_id,
                'photo' => 'default-logo.png',
                'sms_enabled' => 1,
                'email_enabled' => 1,
                'sms_type' => 0,
                'payment_status' => 2,
                'account_manager_id' => $account_manager_id
            );

            $receipt_array = array(
                'show_installment' => 1,
                'show_class' => 1,
                'template' => 'default',
                'available_templates' => 'default,zebra',
                'show_single_fee' => '1',
                'copy_to_print' => 1,
                'show_balance' => 1,
                'show_digital_signature' => 0,
                'show _school_stamp' => 0
            );

            $invoice_setting_array = array(
                'title ' => '',
                'show_banks smallint' => 1,
                'show_payment_plan smallint' => 1,
            );

            $setting = \DB::table($schema . '.setting')->first();
            if (empty($setting)) {
                $set_data = array_merge($derived, $data);
                \DB::table($schema . '.setting')->insert($set_data);
            } else {
                $data_ = array_merge($derived, $data);
                \DB::table($schema . '.setting')->where('sms_enabled', 1)->update($data_);
            }
            $setting = \DB::table($schema . '.setting')->first();

            \App\Model\ReceiptSetting::create($receipt_array);
            \App\Model\InvoiceSetting::create($invoice_setting_array);
            
            if(!empty($client)){
                $bank = DB::table('admin.bank_accounts_integrations')->where('client_id', $this->data['client']->id)->first();

                //Bank Accounts Details
                if(!empty($bank)){
                DB::table($schema.'.bank_accounts')->insert([
                'number' => $bank->account_number, 'branch' =>$bank->branch, 'name' => $bank->account_name, 'refer_bank_id' => 2, 'refer_currency_id' => $bank->refer_currency_id, 'opening_balance' => $bank->opening_balance, 'currency' => 'TZS', 'note' => 'Bank Account Added by Bank During Installation'
                ]);
                }
              } 


            $this->installClassLevel($class_levels);

            DB::table($schema . '.setting')->update(['payment_deadline_date' => date('Y-m-d', strtotime(' +30 day'))]);

            DB::table('admin.users_sequences')->insert([
                'user_id' => 1, 'table' => 'user', 'schema_name' => $schema, 'sequence_id' => 1
            ]);
            $this->createFees();

            //Create KaribuSMS Account
            $background = new \App\Http\Controllers\Background();
            $background->createSmsSetting();
            
            return redirect('https://'. $schema . '.shulesoft.com/install/done/null?u=' . $schema . '&p='. $password);

        } else {
            return view('install.site', $this->data);
        }
    }

    function done() {
        return view('install.done', $this->data);
    }

    function installDemoTeacher() {
        return DB::table('teacher')->count() == 0 ? DB::table('teacher')->insert([
            'teacherID' => 1, 'name' => 'ShuleSoft Default Teacher', 'sex' => 'male',
            'username' => '0755406004', 'phone' => '0755406004', 'password' => bcrypt('0655406004'),
            'dob' => date('Y-m-d'), 'jod' => date('Y-m-d'), 'usertype' => 'teacher'
        ]) : '';
    }

    /**
     * This function will later be modified to fetch records from DB which will be more effective
     * @return $param array
     */
    function createAlevelAcademicYear() {

        if (strtotime(date('Y-m-d')) > strtotime(date('Y') . '-06-01')) {

            $name = date('Y') . '/' . (date('Y') + 1);
            $start_date = date("Y-m-d", strtotime(date('Y') . '-06-01'));
            $end_date = date("Y-m-d", strtotime((date('Y') + 1) . '-05-31'));
        } else {
            $name = (date('Y') - 1) . '/' . date('Y');
            $start_date = date("Y-m-d", strtotime((date('Y') - 1) . '-06-01'));
            $end_date = date("Y-m-d", strtotime(date('Y') . '-05-31'));
        }
        return $param = array("name" => $name, "start_date" => $start_date, "end_date" => $end_date);
    }

    function installClassLevel($class_levels) {
        $this->installDemoTeacher();
        //$class_levels = request('classlevel');
        if(empty($class_levels)){
            $class_levels=array('Primary');
        }
        foreach ($class_levels as $level) {
            $param = array("name" => date('Y'), "start_date" => date("Y-m-d", strtotime(date('Y') . '-01-01')), "end_date" => date("Y-m-d", strtotime(date('Y') . '-12-31')));
            switch ($level) {
                case 'A-level':
                    $data = array('name' => $level, 'span_number' => 2, 'note' => 'Advanced Secondary Level', 'result_format' => 'ACSEE', 'school_level_id' => 4);
                    $arr = array(5, 6);
                    $param = $this->createAlevelAcademicYear();
                    break;
                case 'O-level':
                    $data = array('name' => $level, 'span_number' => 4, 'note' => 'Ordinary Secondary Level', 'result_format' => 'CSEE', 'school_level_id' => 3);
                    $arr = array(1, 2, 3, 4);
                    break;
                case 'Primary':
                    $data = array('name' => $level, 'span_number' => 7, 'note' => 'Primary Level', 'result_format' => 'PSLE', 'school_level_id' => 2);
                    $arr = array(1, 2, 3, 4, 5, 6, 7);
                    break;
                case 'Nursery':
                    $data = array('name' => $level, 'span_number' => 3, 'note' => 'Nursery Level', 'result_format' => 'OTHER', 'school_level_id' => 1);
                    $arr = array(1, 2, 3);
                    break;
                default:
                    break;
            }
            if (DB::table('classlevel')->where('name', $level)->count() == 0) {
                $classlevel_id = DB::table('classlevel')->insertGetId($data, 'classlevel_id');
                $this->installClasses($arr, $classlevel_id);
                $this->installCurrentAcademicYear($param, $classlevel_id);
            }
        }
        $this->install_chart_account();
        $this->install_roles();
        $this->default_grades();
        $this->install_exam_groups();
        //install SMS keys
    }

    function installClasses($arr, $classlevel_id) {
        if (count($arr) == 7) {
            $class = 'Grade ';
        } else if (count($arr) == 3) {
            $class = 'Nursery ';
        } else {
            $class = 'Form ';
        }

        foreach ($arr as $value) {
            $data = [
                'classes' => $class . number_to_words($value),
                'classes_numeric' => $value,
                'teacherID' => 1,
                'note' => '',
                'classlevel_id' => $classlevel_id
            ];

            $insert_class = DB::table('classes')->insertGetId($data, 'classesID');
            //Install Single Section for every added class
            $section_array1 = array(
                "section" => 'A',
                "category" => 'A',
                "classesID" => $insert_class,
                "teacherID" => 1,
                "note" => $class . number_to_words($value) . ' Section A'
            );
            $section_array2 = array(
                "section" => 'B',
                "category" => 'B',
                "classesID" => $insert_class,
                "teacherID" => 1,
                "note" => $class . number_to_words($value) . ' Section B'
            );
            DB::table('section')->insert($section_array1);
            DB::table('section')->insert($section_array2);
        }
    }

    function installCurrentAcademicYear($param, $classlevel_id) {
        $array = array(
            "class_level_id" => $classlevel_id
        );
        $year_id = DB::table('academic_year')->insertGetId(array_merge($array, $param));

        $semester_array1 = array(
            "name" => "First Term",
            "start_date" => date("Y-m-d", strtotime(date('Y') . '-01-01')),
            "end_date" => date("Y-m-d", strtotime(date('Y') . '-06-01')),
            "class_level_id" => $classlevel_id,
            "academic_year_id" => $year_id,
            'study_days' => 100
        );
        $semester_array2 = array(
            "name" => "Second Term",
            "start_date" => date("Y-m-d", strtotime(date('Y') . '-06-01')),
            "end_date" => date("Y-m-d", strtotime(date('Y') . '-12-30')),
            "class_level_id" => $classlevel_id,
            "academic_year_id" => $year_id,
            'study_days' => 100
        );
        DB::table('semester')->insert($semester_array1);
        DB::table('semester')->insert($semester_array2);
    }

    public function install_chart_account() {
        $predefineds = [
                ['name' => "Banks", 'financial_category_id' => 5, 'predefined' => 1],
                ['name' => "Cash", 'financial_category_id' => 5, 'predefined' => 1],
                ['name' => "Account Receivable", 'financial_category_id' => 5, 'predefined' => 1],
                ['name' => "Unearned Revenue", 'financial_category_id' => 6, 'predefined' => 1],
                ['name' => "Retained Earnings", 'financial_category_id' => 7, 'predefined' => 1],
                ['name' => "Depreciation", 'financial_category_id' => 3, 'predefined' => 1],
                ['name' => "Depreciation", 'financial_category_id' => 2, 'predefined' => 1],
                ['name' => "Inventory", 'financial_category_id' => 2, 'predefined' => 1],
                ['name' => "Dispensary", 'financial_category_id' => 2, 'predefined' => 1],
                ['name' => "Employer Contributions", 'financial_category_id' => 3, 'predefined' => 1]];
        foreach ($predefineds as $predefined) {
            $check = DB::table('account_groups')->where($predefined)->first();
            if (empty($check)) {
                DB::table('account_groups')->insert($predefined);
                $check = DB::table('account_groups')->where($predefined)->first();
            }
            if (!empty($check) && $predefined['name'] <> 'Banks') {
                $s_object = ["name" => $check->name,
                    "financial_category_id" => $check->financial_category_id,
                    "account_group_id" => $check->id];
                DB::table('refer_expense')->where($s_object)->count() == 0 ?
                                DB::table('refer_expense')->insert(array_merge(['code' => createCode(), 'predefined' => 1], $s_object)) : '';
            }
        }
    }

    public function install_exam_groups() {
        $predefineds = [
                ['name' => "Main Exams", 'weight' => 80, 'note' => 'List of Exams Performed by all subjects at once', 'predefined' => 1],
                ['name' => "Quizes", 'weight' => 10, 'note' => 'Minor Exams'],
                ['name' => "Assignement", 'weight' => 10, 'note' => 'Minor Exams'],
                ['name' => "Home work", 'weight' => 10, 'note' => 'Minor Exams']];
        foreach ($predefineds as $predefined) {
            $check = DB::table('exam_groups')->where($predefined)->first();
            if (empty($check)) {
                DB::table('exam_groups')->insert($predefined);
            }
        }
    }

    public function install_roles() {
        $predefined = [
                ['name' => "Admin"],
                ['name' => "Parent"],
                ['name' => "Librarian"],
                ['name' => "Teacher"],
                ['name' => "Accountant"],
                ['name' => "Secretary"],
                ['name' => "Head Teacher"],
                ['name' => "Academic Master"],
                ['name' => "Student"]];
        DB::table('role')->count() == 0 ? DB::table('role')->insert($predefined) : '';
    }

    public function default_subject() {
        $classlevels = DB::table('classlevel')->get();
        foreach ($classlevels as $level) {
            $subjects = DB::table('constant.refer_subject_definition')->where('result_format', $level->result_format)->get();
            $classes = DB::table('classes')->where('classlevel_id', $level->classlevel_id)->get();

            foreach ($subjects as $subject) {
                $object = ['subject_name' => $subject->name, 'code' => $subject->code, 'arrangement' => $subject->arrangement];
                $check_refer = DB::table('refer_subject')->where($object)->first();
                if (empty($check_refer)) {
                    $refer_subject_id = DB::table('refer_subject')->insertGetId($object, 'subject_id');
                    foreach ($classes as $class) {
                        $check = DB::table('subject')->where(['classesID' => $class->classesID, 'subject_id' => $refer_subject_id])->get();

                        if (count($check) == 0) {
                            $subject_id = DB::table('subject')->insertGetId([
                                "classesID" => $class->classesID,
                                "subject" => $subject->name,
                                "subject_id" => $refer_subject_id,
                                "subject_type" => 'Core',
                                "is_counted" => 1,
                                "is_penalty" => 0,
                                "pass_mark" => null,
                                'teacherID' => 1,
                                'teacher_name' => 'Default Teacher Name',
                                'is_counted_indivision' => 1
                                    ], 'subjectID');

                            //loop through the section and insert data into section subject teacher
                            $sections_in_class = \App\Model\Section::where('classesID', $class->classesID)->get();
                            if (count($sections_in_class) > 0) {
                                foreach ($sections_in_class as $section) {
                                    $section_subject_array = array(
                                        "subject_id" => $subject_id,
                                        "section_id" => $section->sectionID,
                                    );
                                    $sec_sub_check = DB::table('subject_section')->where($section_subject_array)->get();
                                    if (count($sec_sub_check) > 0) {
                                        DB::table('subject_section')->insert($section_subject_array);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return redirect(base_url("subject/all_subject"))->with('success', 'success');
    }

    public function default_grades() {
        $classlevels = DB::table('classlevel')->get();

        foreach ($classlevels as $level) {
            $grades = DB::table('constant.refer_grades')->get();
            foreach ($grades as $grade) {
                $object = ['grade' => $grade->grade, 'point' => $grade->point, 'gradefrom' => $grade->gradefrom, 'gradeupto' => $grade->gradeupto, 'note' => $grade->note, 'classlevel_id' => $level->classlevel_id, 'overall_academic_note' => $grade->overall_academic_note, 'overall_note' => $grade->overall_note];

                !empty(DB::table('grade')->where($object)->first()) ? '' : DB::table('grade')->insert($object);
            }
        }
        return redirect(base_url("grade/index"))->with('success', 'success');
    }

}
