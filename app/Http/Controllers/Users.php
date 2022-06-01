<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Imports\UsersImport;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use DateTime;
use App\Mail\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Controller {

    public function __construct() {
        $this->middleware('auth');
          $this->data['insight'] = $this;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->data['users'] = $this->shulesoftUsers();
        return view('users.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $users = User::where('created_by', Auth::user()->id)->get();
        $roles = DB::table('roles')->get();
        return view('users.create', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'phone' => 'required|max:255|unique:users',
            'email' => 'required|max:255|unique:users',
            'salary' => 'required',
        ]);
        $user = array_merge(request()->except('_token','location'), ['password' => bcrypt(request('email')), 
                           'salary' => remove_comma(request('salary')), 'created_by' => \Auth::user()->id]);
         $user_id = DB::table('admin.users')->insertGetId($user);

         $user_data = DB::table('admin.users')->where('id',(int)$user_id)->first();

         DB::table('accounts.user')->insert([
                    'name' => request('firstname').' '.request('lastname'),
                    'dob' => date("Y-m-d", strtotime(request('date_of_birth'))),
                    'sex' => request('sex'),
                    'email' => request('email'),
                    'phone' => validate_phone_number(str_replace('-', '', request("phone"))),
                    'address' => request('town'),
                    'jod' => date("Y-m-d", strtotime(request('joining_date'))),
                    'username' => str_replace(" ", '', request("phone")),
                    'password' => bcrypt(request('email')),
                    'usertype' => 'student',
                    'role_id' => 10, // student role
                    'salary' => remove_comma(request('salary')),
                    'default_password' => bcrypt(request('email')),
                    'status' => 1,
                    'photo' => 'defualt.png',
                    'bank_account_number' => request('bank_account'),
                    'bank_name' => request('bank_name'),
                    'sid' => $user_data->sid,
                    'religion_id' => 1,
                    'town' => request('town'),
                    'country_id' => 1
                ]);

        $this->sendEmailAndSms($request);

        return redirect('users/index')->with('success', 'User ' . $request['firstname'] . ' created successfully');
    }

 
    public function userUpload() 
    {
        Excel::import(new UsersImport, request()->file('user_file'));
        return redirect('Users/show/'.Auth::User()->id)->with('success', 'All Users Uploaded Successfully!');
    }

    public function resetPassword() {
        $id = request()->segment(3);
        $pass = 'shulesoft_' . rand(32323, 443434344) . '';
        $user = User::find($id);
        $user->update(['password' => bcrypt($pass)]);

        $content = 'Hello ' . $user->name . ' Your password has been updated by administrator. Kindly login  with username ' . $user->email . ' and password ' . $pass;
        $this->sendEmailAndSms($user, $content);
        return redirect()->back()->with('success', 'Password sent successfully');
    } 


    public function sendEmailAndSms($requests, $content = null) {
        $request = (object) $requests;
        $message = $content == null ? 'Hello ' . $request->name . ' You have been added in ShuleSoft Administration panel. You can login for Administration of schools with username ' . $request->email . ' and password ' . $request->email : $content;
        \DB::table('public.sms')->insert([
            'body' => $message,
            'user_id' => 1,
            'phone_number' => $request->phone,
            'table' => 'setting',
            'priority' => 1
        ]);

       $this->send_whatsapp_sms($request->phone, $message); 

        // \DB::table('public.email')->insert([
        //     'body' => $message,
        //     'subject' => 'ShuleSoft Administration Credentials',
        //     'user_id' => 1,
        //     'email' => $request->email,
        //     'table' => 'setting'
        // ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */

    public function show() {
        $id = (int) request()->segment(3) == 0 ? Auth::user()->id : request()->segment(3);
        $this->data['user'] = $user = User::findOrFail($id);
        $this->data['user_permission'] = \App\Models\Permission::whereIn('id', \App\Models\PermissionRole::where('role_id', $this->data['user']->role_id)->get(['permission_id']))->get(['id']);
        $this->data['attendances'] = DB::table('attendances')->where('user_id', $id)->latest()->get();
        $this->data['absents'] = \App\Models\Absent::where('user_id', $id)->latest()->get();
        $this->data['documents'] = \App\Models\LegalContract::where('user_id', $id)->latest()->get();
        $this->data['learnings'] = \App\Models\Course::whereIn('id', \App\Models\UserCourse::where('user_id',$id)->get(['course_id']))->latest()->get();

        //default number of days 22 to minutes
        $this->data['minutes'] = 22*24*60;


        if ($_POST) { 
            //check if its attendance or not
            $ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);
            if ($ip == '102.69.164.2') { //192.168.2.114
                if (strlen(request('early_leave_comment')) > 2) {
                    DB::table('attendances')->where('user_id', $id)->whereDate('created_at', date('Y-m-d'))->update([
                        'timeout' => 'now()',
                        'early_leave_comment' => request('early_leave_comment')
                    ]);
                } else {
                    DB::table('attendances')->insert([
                        'status' => 1,
                        'timein' => date('Y-m-d H:i:s', strtotime(timeZones(date('Y-m-d H:i:s')))),
                        'user_id' => $id,
                        'late_comment' => request('late_comment')
                    ]);
                }
                return redirect()->back()->with('success', 'success');
            } else {
                return redirect()->back()->with('error', 'Error: This action can only be done at the office, using Flashnet Internet connection');
            }
        }
        return view('users.show', $this->data);
    }


    public function perMinute(){
        $allMinutes = [];
        //Assume user id
        $user_id =  118;
        //Selet all date of that month, divide one from another , get hours and add them in a loop
        // by array push method, 
        //  if the outtime is less than 17, with ealry leave comment available , then ealry leave time - intime
        // date('Y', strtotime($attendance->timein)) > 1970 ? date('h:i', strtotime($attendance->timein)) : ''

        $times = DB::table('admin.attendances')->select(['timein','timeout'])->where('user_id', $user_id)->whereMonth('created_at', date('m'))->get();
        foreach($times as $value){
           $startTime =  date('h:i', strtotime($value->timein));
           $OutTime =  '17:00'; // saa 11 jioni
           $endTime  =  date('h:i', strtotime($value->timeout)) > $OutTime  ?  $OutTime  : date('H:i', strtotime($value->timeout));
           $startTime = new DateTime($startTime);
           $endTime = new DateTime($endTime);
           $time = explode(':', $startTime->diff($endTime)->format('%H:%i'));
           $minutes = $time[0]*60 +$time[1];
           array_push($allMinutes, $minutes);
        }
        // return all working minutes per person
        dd($allMinutes);

    }

    public function leave() {
        DB::table('attendances')->where('user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))->update([
            'timeout' => 'now()'
        ]);
        return redirect()->back()->with('success', 'success');
    }
  

    public function shulesoftUsers(){
        $array = array(7,15);
         return  DB::table('admin.users')->where('status', 1)->whereNotIn('role_id',$array)->get();
       // return  \App\Models\User::where(['status'=>1])->get();
    }

    public function absent() {
        if ($_POST) {
            $file = request()->file('file');
            if(filesize($file) > 2015110 ) {
                return redirect()->back()->with('error', 'File must have less than 2MBs');
             }
            $absent_reason_id = request('absent_reason_id'); 
            switch ($absent_reason_id) {
                  //Martenity leave 90 days
                case 3 : 
                   $end_date = date('Y-m-d', strtotime("+90 days", strtotime(request('date'))));
                 break;
                  //Partenity leave 3 days
                 case 4 :
                   $end_date = date('Y-m-d', strtotime("+3 days", strtotime(request('date'))));
                 break;

                 case 8:
                   $end_date = date('Y-m-d', strtotime("+28 days", strtotime(request('date'))));
                 break;
                default:
                   $end_date = date('Y-m-d', strtotime(request('end_date')));
                 break;
               } 
          
            $file_id = $file ? $this->saveFile($file,TRUE) : 1;
            \App\Models\Absent::create(['date' => request('date'), 'user_id' => request('user_id'), 'absent_reason_id' => request('absent_reason_id'),
            'note' => request('note'), 'company_file_id' => $file_id,'end_date' => $end_date]);
        }
        return redirect()->back()->with('success', 'success');
    }

    public function askleave(){
        $id = (int) request()->segment(3);
        $request = request()->segment(4);
       
        if($request == 'approve'){
            $approved = \App\Models\Absent::where('id',$id)->update(['approved_by' =>Auth::user()->id,'status'=>'Approved']);
            if($approved){
                $user = \App\Models\User::where('id',\App\Models\Absent::where('id',$id)->first()->user_id)->first();
                $end_date = \App\Models\Absent::where('id',$id)->first()->end_date;
            }
            $message = 'Hello '. $user->firstname . ' ' . $user->lastname 
                    . ' Your request has been granted '
                    . ' which has to end at '. date('d-m-Y', strtotime($end_date)). '';
                    
            $this->send_email($user->email, 'Success: Absent leave granted', $message);
             $this->send_sms($user->phone, $message, 1);

            return redirect()->back()->with('success','Approved successfully');
        }
        //If leave request rejected, Dont give paid leave
        if($request == 'reject'){
            \App\Models\Absent::where('id',$id)->update(['status'=>'Rejected']);
            return redirect()->back()->with('success','Rejected successfully');
        }
    }


    public function editLeaveDates(){
         $absent_id = request('absent_id');
         $user_id = request('tag');
         $end_date = request('val');
         $updat =  \App\Models\Absent::where(['id' => $absent_id, 'user_id'=>$user_id])->update(['end_date'=> $end_date]);
         echo $updat > 0 ? 'success' : 'error';
    }

    public function password() {
        $this->data['user'] = User::find(Auth::user()->id);
        return view('auth.change_password', $this->data);
    }

    public function storePassword(Request $request) {
        $user = User::find(Auth::user()->id);
        if (Auth::attempt(['email' => $user->email, 'password' => request('password')])) {
            $new1 = request('new');
            $new2 = request('retype');
            if ($new1 != $new2) {
                return redirect()->back()->with('error', 'New password and confirmed one  do not match');
            }
            $this->validate(request(), [
                'retype' => 'required|string|min:6'
                    ], ['Password must be 6–30 characters, and include a number, a symbol, a lower and a upper case letter']);
            $user->update(['password' => \Hash::make($new1)]);
            return redirect()->back()->with('success', 'Password changed successfully');
        } else {
            return redirect()->back()->with('error', 'Current Password is not valid');
        }
        return redirect()->back()->with('success', 'Password Updated successfully');
    }

    public function addPermission() {
        $permission_id = request('id');
        $role_id = request('role_id');
        $data = array(
            'role_id' => $role_id,
            'permission_id' => $permission_id
        );

        $insert_id = DB::table('permission_role')->insertGetId($data, 'id');
        if ($insert_id > 1) {
            echo 'Success';
        } else {
            echo 'Error: Please Refresh this page';
        }
    }

    public function removePermission() {
        $permission_id = request('id');
        $role_id = request('role_id');
        $data = array(
            'role_id' => $role_id,
            'permission_id' => $permission_id
        );
        DB::table('permission_role')->where($data)->delete();
        echo 'success';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        $id = request()->segment(3);
        $this->data['user'] = User::find($id);
       
        if ($_POST) {
            $this->validate(request(), [
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'phone' => 'required|max:255',
            ]);
           
             $data = request()->except('salary');
             $usedata = array_merge(['salary' => remove_comma(request('salary'))], $data);
             $user = User::find($id)->update($usedata);

             //update account package as well  
             DB::table("accounts.user")->where('sid', (int)$this->data['user']->sid)->update([
                    'name' => request('firstname').' '.request('lastname'),
                    'dob' => date("Y-m-d", strtotime(request('date_of_birth'))),
                    'sex' => request('sex'),
                    'email' => request('email'),
                    'phone' => validate_phone_number(str_replace('-', '', request("phone"))),
                    'address' => request('town'),
                    'jod' => date("Y-m-d", strtotime(request('joining_date'))),
                    'username' => str_replace(" ", '', request("phone")),
                    'password' => bcrypt(request('email')),
                    'usertype' => 'student',
                    'role_id' => 10, // student role
                    'salary' => remove_comma(request('salary')),
                    'default_password' => bcrypt(request('email')),
                    'status' => 1,
                    'photo' => 'defualt.png',
                    'bank_account_number' => request('bank_account'),
                    'bank_name' => request('bank_name'),
                    'religion_id' => 1,
                    'town' => request('town'),
                    'country_id' => 1,
                 ]);

            return redirect('/users/show/'.$id)->with('success', 'User ' . request('firstname') . ' ' . request('lastname') . ' updated successfully');
        }
        $this->data['id'] = $id;

        return view('users.edit', $this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy() {
         $user_id = request('user_id');
         $reason_id = request('reason_id');
         $user_data = DB::table("admin.users")->where('id', (int)$user_id)->first();
        
         DB::table("admin.users")->where('id', $user_id)->update(['status' => 0,'deleted_at'=>'now()']);

         DB::table("accounts.user")->where('sid', (int)$user_data->sid)->update(['status' => 0,'expire_at'=>'now()']);
         $email = \App\Models\User::where('id',$user_id)->first()->email;
         DB::table("admin.user_turnover")->insert(['user_id' => $user_id,'reason_id' => $reason_id]);

         DB::table("admin.zone_managers")->where('user_id',$user_id)->delete();
       
        if($email){
           DB::table("public.user")->where('email', $email)->delete();
        }
        return redirect('users/index')->with('success', 'Removed successfully');
    }

    public function management() {
        $sql = 'SELECT * FROM public.crosstab(\'select "schema_name"::text,"table",count(*) from admin.all_users where status=1  group by "schema_name"::text,"table" order by 1,2\', \'select distinct "table"::text from admin.all_users order by 1\') AS final_result("schema_name" text,"parent" text,"setting" text, "student" text, "teacher" text, "user" text)';
        $this->data['users'] = DB::select($sql);
        return view('users.school_users', $this->data);
    }

    public function contact() {
        $this->data['settings'] = DB::table('admin.all_setting')->get();
        return view('users.school_contact', $this->data);
    }

    public function banks() {
        $this->data['settings'] = DB::table('admin.all_setting')->get();
        $seg = request()->segment(3);
        if (strlen($seg) > 2) {
            $this->data['banks'] = DB::select('select b.*,a.api_username,a.api_password,a.invoice_prefix,a.sandbox_api_username,a.sandbox_api_password from ' . $seg . '.bank_accounts_integrations a right join ' . $seg . '.bank_accounts b on a.bank_account_id=b.id');
        }
        $this->data['schema'] = $seg;
        return view('users.school_account', $this->data);
    }


    //Changing user profile image
    public function changePhoto() {
          $file = request()->file('photo');
          $filesize = filesize($file);
          if($filesize > 2000048 ){ return redirect()->back()->with('warning','your image file is too big'); }
          $user_file_id = $this->saveFile($file,true);
          $data = [
            'company_file_id' => $user_file_id
          ];
          \App\Models\User::where('id', request()->segment(3))->update($data);
          return redirect()->back()->with('success','Updated successfully');
    }

    public function applicant() {
        $this->data['applicants'] = DB::table('admin.applicants')->get();
        $this->data['applicant'] = DB::table('admin.applicants')->first();
        return view('users.applicant', $this->data);
    }

    public function template() {
        
    }

    public function notification() {
        $this->data['tasks'] = \App\Models\Task::where('to_user_id', Auth::user()->id)->orWhere('user_id', Auth::user()->id)->orderBy('date', 'desc')->get();
        return view('users.notification', $this->data);
    }

    public function report() {
        $from = request('from');
        $to = request('to');
        $user_id = request('user_id');
        $tasks = DB::select("select b.name, count(a.*) from admin.tasks a join admin.task_types b on b.id=a.task_type_id where  a.user_id=" . $user_id . " and a.created_at between '" . date('Y-m-d', strtotime($from)) . "' AND '" . date('Y-m-d', strtotime($to)) . "'  group by b.name");
        $tr = '';
        foreach ($tasks as $task) {
            $tr .= '<tr><td>' . $task->name . '</td><td>' . $task->count . '</td></tr>';
        }
        $message = ''
                . '<h5>Report From ' . $from . ' To ' . $to . '</h5>'
                . '<p></p>'
                . '<table class="table"><thead><tr><th>Activity Name</th><th>Number of Activities</th></tr></thead><tbody>' . $tr . '</tbody></table>';
        echo $message;
    }

    public function minutes() {
        $this->data['minutes'] = \App\Models\Minutes::orderBy('id', 'DESC')->get();
        return view('users.minutes.minutes', $this->data);
    }

    public function addMinute() {
        if ($_POST) {
            $filename = '';
            if (!empty(request('attached'))) {
                $file = request()->file('attached');
                $filename = time() . rand(11, 8894) . '.' . $file->guessExtension();
                $filePath = base_path() . '/storage/uploads/images/';
                $file->move($filePath, $filename);
            }

            $array = [
                'title' => request('title'),
                'note' => request('note'),
                'date' => request('date'),
                'start_time' => request('start_time'),
                'end_time' => request('end_time'),
                'department_id' => request('department_id'),
                'attached' => $filename
            ];
            $minute = \App\Models\Minutes::create($array);
            if (!empty($minute->id) && request('user_id')) {
                $modules = request('user_id');
                foreach ($modules as $key => $value) {
                    if (request('user_id')[$key] != '') {
                        $array = ['user_id' => request('user_id')[$key], 'minute_id' => $minute->id];
                        $check_unique = \App\Models\MinuteUser::where($array);
                        if (empty($check_unique->first())) {
                            \App\Models\MinuteUser::create($array);
                        }
                    }
                }
            }
            return redirect('users/minutes')->with('success', request('title') . ' updated successfully');
        }
        $this->data['users'] = \App\Models\User::all();
        return view('users.minutes.addminute', $this->data);
    }

    public function showMinute() {
        $id = request()->segment(3);
        $this->data['minute'] = \App\Models\Minutes::where('id', $id)->first();
        return view('users.minutes.view_minute', $this->data);
    }

    public function deleteMinute() {
        $id = request()->segment(3);
        \App\Models\Minutes::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Minute Deleted successful');
    }

    public function tasks() {
        $this->data['users'] = 1;
        return view('users.tasks', $this->data);
    }

    public function storeChat() {
        $root = url('/') . '/public/';
        $id = Auth::user()->id;
        $to = request('to_user_id');
        $message = \App\Models\Chat::create(['body' => request('body'), 'status' => 1]);
        \App\Models\ChatUser::create(['user_id' => $id, 'to_user_id' => $to, 'message_id' => $message->id]);
        $this->getUser($to);
        //  return redirect()->back()->with('success', 'Message Sent');
    }

    public function getUser($id) {
        if (request('to_user_id') != '') {
            $id = request('to_user_id');
        } else {
            $id = $id;
        }
        $to = Auth::user()->id;
        $user = \App\Models\User::where('id', $id)->first();
        $send = "'send'::text AS sends";
        $rec = "'receive'::text AS sends";
        $results = DB::SELECT('SELECT a.body,a.created_at,b.user_id as user_id, ' . $send . ' from admin.chats a, admin.chat_users b where a.id=b.message_id and b.user_id =' . $id . ' AND b.to_user_id=' . $to . ' UNION ALL SELECT a.body,a.created_at,b.to_user_id as user_id, ' . $rec . ' from admin.chats a, admin.chat_users b where a.id=b.message_id and b.user_id =' . $to . ' AND b.to_user_id=' . $id);
        //  \App\Models\ChatUser::where('user_id', $id)->where('to_user_id', $to)->get();
        $root = url('/') . '/public/';
        $message1 = '';
        $message1 .= '<div class="media chat-inner-header">
        <a class="back_chatBox">
        <input id="to_user_id' . $user->id . '" value="' . $user->id . '" type="hidden">
            <i class="icofont icofont-rounded-left"></i>' . $user->firstname . ' ' . $user->lastname . '
        </a>
    </div>';
        if (count($results) > 0) {
            foreach ($results as $message) {
                if ($message->sends == 'send') {
                    $message1 .= '<div class="media chat-messages">
                                    <a class="media-left photo-table" href="#!">
                                    <img class="media-object img-circle m-t-5" src="' . $root . 'assets/images/avatar-1.png" alt="Image">
                                    </a>
                                    <div class="media-body chat-menu-content">
                                        <div class="">
                                            <p class="chat-cont">' . $message->body . '<br>
                                            <b>' . $message->created_at . '</b></p>
                                        </div>
                                    </div>
                                </div>';
                } else {
                    $message1 .= '<div class="media chat-messages">
                                    <div class="media-body chat-menu-reply">
                                        <div class="">
                                        <p class="chat-cont">' . $message->body . '
                                        <br>
                                            <b>' . $message->created_at . '</b>
                                        </p>
                                        </div>
                                    </div>
                                    <div class="media-right photo-table">
                                        <a href="#!">
                                            <img class="media-object img-circle m-t-5" src="' . $root . 'assets/images/avatar-2.png" alt="Image">
                                        </a>
                                    </div>
                                </div>';
                }
            }
        } else {
            $message1 .= '<div class="media chat-messages">
                         <div class="media-body chat-menu">
                             <div class="">
                             <p class="chat-cont"> No new message...</p>
                             </div>
                             </div>
                         </div>';
        }
        $message1 .= '<div class="chat-reply-box p-b-20">
                      <div class="right-icon-control">
                      <textarea rows="4" id="body" class="form-control search-text" placeholder="Type Here.."></textarea>
                      <button type="button" class="btn btn-primary btn-sm" onmousedown="send_message(' . $id . ')"> Send </button>

                      </div>
                  </div>';

        echo $message1;
    }

    public function getBranch() {
        $id = request('region');

        $branches = \App\Models\PartnerBranch::whereIn('district_id', \App\Models\District::where('region_id', $id)->get(['id']))->where('partner_id', request('partner_id'))->get();
        if (count($branches) > 0) {
            $select = '';
            foreach ($branches as $branch) {
                $select .= '<option value="' . $branch->id . '"> ' . $branch->name . '</option>';
            }
            echo $select;
        } else {
            echo $select;
        }
    }

    

    public function getBankId() {
        $partner_user = \App\Models\PartnerUser::whereIn('user_id', [Auth::user()->id])->first();
        if (empty($partner_user)) {
            //LATER ON ADD A TABLE TO MAP USER AND PARTNER
            //create a branch\
            if (preg_match('/nmb/i', Auth::user()->email)) {
                $id = 1;
            } else {
                $id = 2;
            }
          //  $partner = DB::table('admin.partners')->where('id', 1)->first();
            $partner_branch = \App\Models\PartnerBranch::create(['name' => 'HQ', 'phone_number' => Auth::user()->phone, 'partner_id' => $id, 'district_id' => 3]);
            //add a partner
            $partner_user = \App\Models\PartnerUser::create(['user_id' => Auth::user()->id, 'branch_id' => $partner_branch->id]);
        }
        if (preg_match('/nmb/i', $partner_user->branch->partner->name)) {
            $refer_bank_id = 22;
        } else {
            $refer_bank_id = 8;
        }
        return $refer_bank_id;
    }





      public function legalcontract(){
        if ($_POST) {
            $file = request()->file('file');
            if(filesize($file) > 2015110 ) {
                return redirect()->back()->with('error', 'File must have less than 2MBs');
             }
           $file_id = $file ? $this->saveFile($file,TRUE) : 1; 
           $arr = ['name' => request('contract_legal'),'start_date'=>request('start_date'),'end_date'=>request('end_date'),
           'user_id' => request('user_id'),'company_file_id' => $file_id ,'description' => request('description')];
             \App\Models\LegalContract::create($arr);
        return redirect()->back()->with('success', 'updated successful!');
      }
  }



    public function usergroup(){
        $tab = request()->segment(3);
        $this->data['groups'] = \App\Models\Group::get();
        if($tab == 'add'){
            if($_POST){
                $this->validate(request(), [
                    'name' => 'required|max:255',
                    'email' => 'required|email',
                    'phone' => 'required|max:255'
                ]);

                $data = [
                    'name' => request('name'),
                    'email' => request('email'),
                    'phone_number' => request('phone'),
                    'note' => request('note'),
                    'status' => 1,
                ];
                $group_id = DB::table('admin.groups')->insertGetId($data);
                if (!empty($group_id) && request('to_client_id')) {
                    $clients = request('to_client_id');
                    foreach ($clients as $key => $client) {
                      if (request('to_client_id')[$key] != '') {
                        $array = ['client_id' => request('to_client_id')[$key], 'group_id' => $group_id];
                          $check_unique = \App\Models\ClientGroup::where($array);
                            if(empty($check_unique->first())) {
                                \App\Models\ClientGroup::create($array);
                            } else{
                            return redirect()->back()->with('error','Client school arleady belong to groups');
                            }
                        }
                    }
                }
                return redirect(url("users/usergroup"))->with('success', 'Group created successful!'); 
            }
            return view('users.groups.add', $this->data);
        }
        return view('users.groups.usergroups', $this->data);
    }


    public function group_clients(){
        $g_id = request()->segment(3);
        if($g_id > 0){
            $this->data['group'] = \App\Models\Group::findOrFail($g_id);
            $this->data['schools'] = \App\Models\Client::whereIn('id',\App\Models\ClientGroup::where('group_id', $g_id)->get(['client_id']))->get();
        }
        return view('users.groups.schools', $this->data);
    }

     public function learning(){
        $learning_id = request()->segment(3);
        
         if($_POST){
             $array= [
                 'course_name' => request('course_name'),
                 'source' => request('source'),
                 'from_date' => request('from_date'),
                 'to_date' => request('to_date'),
                 'created_by' => request('user_id'),
                 'has_certificate' => request('has_certificate'),
                 'descriptions' => request('description'),
                 'course_link' => request('link')
             ];
           $course_id = \App\Models\Course::insertGetId($array);

           \App\Models\UserCourse::create(['user_id' => request('user_id'), 'course_id' => $course_id]);
            return redirect()->back()->with('success','success');
         }
       
         if($learning_id > 0){
            $this->data['learning'] = \App\Models\Course::where('id',$learning_id)->first();                 
            $this->data['users'] = \App\Models\User::whereIn('id',\App\Models\UserCourse::where('course_id',$learning_id)->get(['user_id']))->get();
            return view('users.learning_details', $this->data);
        }

        
        return redirect()->back()->with('success', 'success');
     }

     public function learningDelete(){
        $learning_id = request()->segment(3);
         \App\Models\Course::where('id',$learning_id)->delete();
       return redirect()->back()->with('success', 'deleted successful!');
     }

     
     public function certification(){
        $learning_id = request()->segment(3);
        if ($_POST) {
            $file = request()->file('certificate');
            if(filesize($file) > 2015110 ) {
                return redirect()->back()->with('error', 'File must have less than 2MBs');
             }
            $file_id = $this->saveFile($file,TRUE); 
           \App\Models\Course::where('id', (int) $learning_id)->update(['company_file_id' => $file_id]);
       }
       return redirect()->back()->with('success', 'updated successful!');
   }


    public function updateDesignation(){
        if($_POST){
             \App\Models\User::where('id',request('user_id'))->update(['designation_id' => request('designation_id')]);
            }
        return redirect()->back()->with('success', 'updated successful!');
    }

  
    public function hrrequest() {
         $page = request()->segment(3);
        if ((int) $page == 1 || $page == 'null' || (int) $page == 0) {
            //current day
            $this->data['today'] = 1;
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
            $where = '  a.created_at::date=CURRENT_DATE';
        } else {
            $this->data['today'] = 2;
            $start_date = date('Y-m-d', strtotime(request('start')));
            $end_date = date('Y-m-d', strtotime(request('end')));
            $where = "  a.created_at::date >='" . $start_date . "' AND a.created_at::date <='" . $end_date . "'";
        }
         $user_id = \Auth::User()->id;
      //   $this->data['schools'] = DB::select("select * from admin.tasks where user_id = $user_id  and  (start_date, end_date) OVERLAPS ('$start_date'::date, '$end_date'::date)");
        $this->data['schools'] = \App\Models\Task::where('user_id', Auth::user()->id)->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $this->data['new_schools'] = \App\Models\Task::where('user_id', Auth::user()->id)->where('next_action', 'new')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $this->data['pipelines'] = \App\Models\Task::where('user_id', Auth::user()->id)->where('next_action', 'pipeline')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $this->data['closeds'] = \App\Models\Task::where('user_id', Auth::user()->id)->where('next_action', 'closed')->whereRaw("(created_at >= ? AND created_at <= ?)", [$start_date . " 00:00:00", $end_date . " 23:59:59"])->orderBy('created_at', 'desc')->get();
        $this->data['query'] = 'SELECT count(next_action), next_action from admin.tasks a where  a.user_id='.Auth::User()->id.' and ' . $where . ' group by next_action order by count(next_action) desc';
        $this->data['types'] = 'SELECT count(b.name), b.name as type from admin.tasks a, admin.task_types b  where a.task_type_id=b.id AND a.user_id ='.Auth::User()->id.' and ' . $where . ' group by b.name order by count(b.name) desc';
        return view('users.hr.index', $this->data);
    }

    
     public function addLead() {
        if ($_POST) {
            $data = array_merge(request()->except('to_user_id'), ['user_id' => Auth::user()->id, 'status' => 'new', 'date' => date('Y-m-d')]);
            $task = \App\Models\Task::create($data);

            DB::table('tasks_users')->insert([
                'task_id' => $task->id,
                'user_id' => Auth::user()->id
            ]);

            $school_id = request('school_id');

            if (preg_match('/c/i', $school_id)) {

                DB::table('tasks_clients')->insert([
                    'task_id' => $task->id,
                    'client_id' => (int) $school_id
                ]);
            }
            if ((int) $school_id > 0 && !preg_match('/c/i', $school_id)) {

                DB::table('tasks_schools')->insert([
                    'task_id' => $task->id,
                    'school_id' => (int) $school_id
                ]);
            }

            if (request('school_name') != '' && request('school_phone') != '') {
                \App\Models\SchoolContact::create([
                    'name' => request('school_name'),
                    'phone' => request('school_phone'),
                    'school_id' => (int) $school_id,
                    'user_id' => Auth::user()->id,
                    'title' => request('school_title')
                ]);
                DB::table('admin.schools')->where('id', (int) $school_id)->update(['students' => request('students')]);
            }

            return redirect('users/hrrequest/1')->with('success', 'success');
        }
        return view('users.hr.add', $this->data);
    }

    public function usersignature(){ 
         $this->data['user_id'] = $user_id = request('user_id');
         $this->data['payment_date'] = $payment_date = request('payment_date');
         return view('users.signature', $this->data);
      }

       public function updatesignature(){ 
              $signature = str_replace(' ', '+', request('signed'));
              $file_name = time() . ".png";
              $this->data['user_id'] = $user_id = request('user_id');
               $this->data['payment_date'] = $payment_date = request('payment_date');
              $update = !empty($signature) ? \App\Models\User::where('id',(int) $user_id)->update(['signature'=>$signature,'signature_path' => $file_name]) : '';

              $month = date('m', strtotime($payment_date));
              $_url = "payroll/payslip/null/?id=$user_id&month=$month&set=$payment_date";

              if($update > 0){
                 return redirect($_url);
              }else{
                 return view('users.signature', $this->data); 
              }
             
      }


      public function courses(){
         $this->data['users'] = \App\Models\User::where('status',1)->whereNotIn('role_id',[7,15])->get();
         $this->data['courses'] = \App\Models\Course::latest()->get();
         if($_POST){
            $user_ids = request('user_ids');
            $course_id = \App\Models\Course::insertGetId([
                'course_name' =>request('course_name'),
                'created_by' => Auth::user()->id,
                'from_date' => request('from_date'),
                'to_date' => request('to_date'),
                'source' => request('source'),
                'descriptions' => request('description'),
                'course_link' => request('url')
              ]);
        
             foreach ($user_ids as $user_id) {
                \App\Models\UserCourse::create(['user_id' => $user_id, 'course_id' => $course_id]);
                 $user = \App\Models\User::where(['id' => $user_id])->first();
                  if(!empty($user)){
                    $message = 'Hello '. $user->name()                              
                                . chr(10) . 'You have been assigned new course'
                                . chr(10) . 'Title:' . request('course_name') .''
                                . chr(10) .  request('description')  .''
                                . chr(10) .  request('url')  .''
                                . chr(10) . 'Deadline '. date('d-m-Y',strtotime(request('to_date')));
                     $this->send_whatsapp_sms($user->phone, $message); 
                     $this->send_sms($user->phone,$message,1);
                }
              }
            return redirect()->back()->with('success','Course created successfull!');
         }
         return view('users.hr.courses', $this->data);
      }


      public function updateAttendances(){
          dd(request()->all());
      }

}