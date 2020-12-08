<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;

class Users extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->data['users'] = User::where('status', 1)->where('role_id', '<>', 7)->get();
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
            'email' => 'required|max:255|unique:users'
        ]);
        $user = new User(array_merge($request->all(), ['password' => bcrypt(request('email')), 'created_by' => Auth::user()->id]));
        $user->save();
        $this->sendEmailAndSms($request);

        return redirect('users/index')->with('success', 'User ' . $request['firstname'] . ' created successfully');
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
            'table' => 'setting'
        ]);
        \DB::table('public.email')->insert([
            'body' => $message,
            'subject' => 'ShuleSoft Administration Credentials',
            'user_id' => 1,
            'email' => $request->email,
            'table' => 'setting'
        ]);
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
        $this->data['user'] = User::find($id);

        $this->data['user_permission'] = \App\Models\Permission::whereIn('id', \App\Models\PermissionRole::where('role_id', $this->data['user']->role_id)->get(['permission_id']))->get(['id']);

        return view('users.show', $this->data);
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
                return redirect()->back()->with('error', 'New password and confirmed one  do not matchs');
            }
            $this->validate(request(), [
                'new2' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
                    ], ['Password must be 8–30 characters, and include a number, a symbol, a lower and a upper case letter']);
            $user->update(['password' => Hash::make($new1)]);
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

            $filename = '';
            if (!empty(request('medical_report'))) {
                $file = request()->file('medical_report');
                $filename = time() . rand(11, 8894) . '.' . $file->guessExtension();
                $filePath = base_path() . '/storage/uploads/images/';
                $file->move($filePath, $filename);
            }

            $filename1 = '';
            if (!empty(request('academic_certificates'))) {
                $file = request()->file('academic_certificates');
                $filename1 = time() . rand(11, 8894) . '.' . $file->guessExtension();
                $filePath = base_path() . '/storage/uploads/images/';
                $file->move($filePath, $filename1);
            }

            $user = User::find($id)->update(request()->except('medical_report', 'academic_certificates'));
            User::find($id)->update(['medical_report' => $filename, 'academic_certificates' => $filename1]);
            return redirect('/')->with('success', 'User ' . request('firstname') . ' ' . request('lastname') . ' updated successfully');
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
        $id = request()->segment(3);
        DB::table("users")->where('id', $id)->update(['status' => 0]);
        return redirect()->back()
                        ->with('success', 'User deleted successfully');
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

    public function changePhoto() {

        if (request()->file('photo')) {
            $this->validate(\request(), ['image' => 'max:1000'], ['image' => 'The photo size must be less than 1MB']);
            $filename = time() . rand(11, 8844) . '.' . request()->file('photo')->guessExtension();
            $folder = 'storage/uploads/images';
            is_file($folder) ? mkdir($folder, 0777, TRUE) : '';
            Image::make(request()->file('photo'))->resize(132, 185)->save('storage/uploads/images/' . $filename);
            \App\Model\User::where('id', request()->segment(3))->update(['photo' => $filename]);
            return redirect()->back();
        }
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
        return redirect()->back()->with('success', 'Minute Deleted');
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
            $partner = DB::table('admin.partners')->where('email', Auth::user()->email)->first();
            $partner_branch = \App\Models\PartnerBranch::create(['name' => 'HQ', 'phone_number' => Auth::user()->phone,
                        'partner_id' => $partner->id, 'district_id' => 3]);
            //add a partner
            $partner_user = \App\Models\PartnerUser::create(['user_id' => Auth::user()->id, 'branch_id' => $partner_branch->id]);
        }
        if (preg_match('/nmb/i', $partner_user->branch->partner->name)) {
            $refer_bank_id = 22;
        } else {
            $refer_bank_id = 7;
        }
        return $refer_bank_id;
    }

 

  
}
