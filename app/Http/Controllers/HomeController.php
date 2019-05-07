<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    public $emails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->data['users'] = DB::select('select count(*), usertype from all_users group by usertype');
        // $this->data['log_graph'] = $this->createBarGraph();
        return view('home.index', $this->data);
    }

    public function users() {
        
    }

    public function searchInvoice($q) {
        $result = '';
        $invoices = DB::select('select * from api.invoices where lower("reference") like \'%' . strtolower($q) . '%\' or lower(student_name) like \'%' . strtolower($q) . '%\' ');
        foreach ($invoices as $invoice) {

            $result .= '<li><a href="' . url('invoice/' . $invoice->id . '/?p=' . $invoice->schema_name) . '&invoice=' . $invoice->reference . '">                <div class="user-img"><span class="profile-status online pull-right"></span> </div>
                                            <div class="mail-contnet">
                                                <h5>' . $invoice->student_name . '</h5> <span class="mail-desc">Invoice: ' . $invoice->reference . '</span> <span class="time">School: ' . $invoice->schema_name . '</span> </div>
                                        </a></li>';
        }
        return json_encode(array(
            'total' => count($invoices),
            'result' => $result
        ));
    }

    public function store(Request $request) {
        $id = DB::table('faq')->insertGetId(['question' => $request->question, 'answer' => $request->answer, 'created_by' => Auth::user()->id]);
        echo $id > 0 ? 'Success' : ' Error, try again later';
    }

    public function search() {
        $q = request('q');

        $result = '';
        if (strlen($q) > 2) { //prevent empty search which load all results
            if (request('type') == 2) {
                return $this->searchInvoice($q);
            }
            $users = DB::select('select * from admin.all_users where lower(name) like \'%' . strtolower($q) . '%\' or lower(phone) like \'%' . strtolower($q) . '%\' ');
            foreach ($users as $user) {

                $result .= '<li><a href="' . url('profile/' . $user->schema_name . '/' . $user->table . '/' . $user->id) . '">                <div class="user-img"> <img src="public/plugins/images/users/varun.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                            <div class="mail-contnet">
                                                <h5>' . $user->name . '</h5> <span class="mail-desc">User Type: ' . $user->usertype . '</span> <span class="time">School: ' . $user->schema_name . '</span> </div>
                                        </a></li>';
            }
            return json_encode(array(
                'total' => count($users),
                'result' => $result
            ));
        }
    }

    public function searchResult() {
        $this->data['result'] = json_decode($this->search());
        return view('profile.search_results', $this->data);
    }

    public function putMessage($title, $subtitle, $value, $value_desc) {
        return '<div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">' . $title . '</h3>
                <div class="text-right"> <span class="text-muted">' . $subtitle . '</span>
                    <h1>' . $value . '</h1> </div>
                <span class="text-info">' . $value_desc . '</span>
               
            </div>
        </div>';
    }

    public function additionalStatusReport() {
        
    }

    public function createTodayReport() {
        $schema_records = DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN ('pg_catalog','information_schema','constant','admin','api','app','skysat','dodoso')");

        foreach ($schema_records as $record) {
            $schema = $record->table_schema . '.';
            $revenue = \collect(DB::select("select sum(amount) from " . $schema . "total_revenues where date::date='" . date('Y-m-d') . "'"))->first();
            $setting = DB::table($schema . 'setting')->first();
            $expense = \collect(DB::select("select sum(amount) from " . $schema . "total_expenses where date::date='" . date('Y-m-d') . "'"))->first();
            if ($revenue->sum > 0 || $expense->sum > 0) {

                $users = DB::table($schema . 'users')->where(DB::raw('lower(usertype)'), 'admin')->get();
                foreach ($users as $user) {

                    $message = ' <h2><b>
                ' . date('d M Y') . '  Report
 </b></h2><p></p>
        ' . $this->putMessage('Revenue', 'Total Revenue', $setting->currency_symbol . ' ' . number_format($revenue->sum), 'Student Payments +other sources') . $this->putMessage('Expense', 'Total Expense', $setting->currency_symbol . ' ' . number_format($expense->sum), 'Without depreciation') . '
        <br/><p>This is automated report. For more detailed report, please login into your ShuleSoft Account</p>';

                    $link = strtoupper($record->table_schema) == 'PUBLIC' ? 'demo.' : $record->table_schema . '.';
                    $data = ['content' => $message, 'link' => $link, 'photo' => $setting->photo, 'sitename' => $setting->sname, 'name' => ''];
                    \Mail::send('email.default', $data, function ($m) use ($user) {
                        $m->from('noreply@shulesoft.com', 'ShuleSoft Report');
                        $m->to($user->email)->subject(' ' . date('d M Y') . ' Report');
                    });
                }
            }
        }
    }

    /**
     * we send this report every Friday evening, 16:45h
     */
    public function weeklyReport() {
        
    }

    /**
     * we send this report at the end of each month
     */
    public function monthlyReport() {
        
    }

    /**
     * We send this report at the end of each quarter as defined in fee installments
     */
    public function quarterReport() {
        
    }

    /**
     * we send this report at the end of each year as defined in a given academic year
     */
    public function annualReport() {
        
    }

    public function dailyReport() {
        return $this->createTodayReport();
        $schema_records = DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN ('pg_catalog','information_schema','constant','admin','api','app','skysat','dodoso')");

        foreach ($schema_records as $record) {

            // users
            $schema = $record->table_schema . '.';
            $setting = DB::table($schema . 'setting')->select('sname', 'photo', 'email_list')->first();
            if (isset($setting->email_list) && $setting->email_list != '') {

                $this->data['users'] = DB::table($schema . 'users')->where('status', 1)->count();
                $this->data['students'] = DB::table($schema . 'student')->where('status', 1)->count();
                $this->data['added_users'] = DB::table($schema . 'parent')->where(DB::raw('created_at::date'), date('Y-m-d'))->count() + DB::table($schema . 'teacher')->where(DB::raw('created_at::date'), date('Y-m-d'))->count() + DB::table($schema . 'student')->where(DB::raw('created_at::date'), date('Y-m-d'))->count();


                //logs
                $this->data['logs'] = DB::table($schema . 'log')->where(DB::raw('created_at::date'), date('Y-m-d'))->count();
                $this->data['log_parents'] = DB::table($schema . 'log')->where(DB::raw('created_at::date'), date('Y-m-d'))->where('table', 'parent')->count();


                $this->data['sms'] = DB::table($schema . 'sms')->where(DB::raw('created_at::date'), date('Y-m-d'))->count();
                $this->data['total_sms'] = DB::table($schema . 'sms')->count();

                $this->data['email'] = DB::table($schema . 'email')->where(DB::raw('created_at::date'), date('Y-m-d'))->count();
                $this->data['revenue'] = \collect(DB::select("select sum(amount) from " . $schema . "total_revenues where payment_date::date='" . date('Y-m-d') . "'"))->first();


                $this->data['expense'] = \collect(DB::select("select sum(amount) from " . $schema . "expense where date::date='" . date('Y-m-d') . "'"))->first();


                $sql = "select  c.name as parent_name, d.classes, a.dob,a.\"classesID\", a.section, a.\"student_id\", a.name as student_name,c.phone as parent_phone FROM " . $schema . "student a join " . $schema . "student_parents b on b.student_id=a.\"student_id\" JOIN " . $schema . "parent c on c.\"parentID\"=b.parent_id join " . $schema . "classes d on d.\"classesID\"=a.\"classesID\" WHERE 
                    DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) 
                    AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE)";
                $this->data['birthday'] = count(DB::select($sql));
                $this->data['schema'] = ucwords($setting->sname);
                $this->data['content'] = view('email.report', $this->data);
                $this->data['link'] = $record->table_schema;
                $this->data['photo'] = $setting->photo;
                $this->data['name'] = ucwords($setting->sname);
                $data = ['content' => $this->data['content'], 'link' => $schema, 'photo' => $setting->photo, 'sitename' => ucwords($setting->sname), 'name' => ucwords($setting->sname)];
                \Mail::send('email.default', $data, function ($m) use ($setting) {
                    $m->from('noreply@shulesoft.com', 'ShuleSoft');
                    $m->to($setting->email_list)->subject(ucwords($setting->sname) . ' Daily Report');
                });
                echo 'email sent to ' . $setting->email_list;
            }
        }
    }

    public function show($id) {
        if ($id == 'invoice') {
            return $this->invoiceSearch();
        }
    }

    public function invoiceSearch() {
        $this->data['data'] = 1;
        if ($_POST) {
            $q = request('invoice');
            $school_name = strtolower(request('school')) == 'all' ? '' : ' AND "schema_name"=\'' . request('school') . "'";
            $this->data['results'] = DB::select('select * from api.invoices where payment_integrated=1 and (lower("reference") like \'%' . strtolower($q) . '%\' or lower(student_name) like \'%' . strtolower($q) . '%\' ) ' . $school_name);
        }
        return view('home.invoice_search', $this->data);
    }

    function testing() {
        $emails = DB::select('select * from public.all_email limit 8');


        if (!empty($emails)) {
            foreach ($emails as $message) {
                if (filter_var($message->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $message->email)) {

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
                } else {
//skip all emails with ShuleSoft title
//skip all invalid emails
                    DB::update('update ' . $message->schema_name . '.email set status=1 WHERE email_id=' . $message->email_id);
                }
//$this->updateEmailConfig();
            }
        }
    }

}
