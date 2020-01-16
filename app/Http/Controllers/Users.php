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
        $this->data['users'] = User::where('status', 1)->get();
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
        $id = (int)request()->segment(3) ==0 ? Auth::user()->id :request()->segment(3) ;
        $this->data['user'] = User::find($id);

        $this->data['user_permission'] = \App\Models\Permission::whereIn('id', \App\Models\PermissionRole::where('role_id', $this->data['user']->role_id)->get(['permission_id']))->get(['id']);

        return view('users.show', $this->data);
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
        $user = User::find($id);

        if ($_POST) {
            $this->validate(request(), [
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'phone' => 'required|max:255',
            ]);
            $user = User::find($id)->update(request()->all());


            return redirect('users/index')->with('success', 'User ' . request('firstname') . ' ' . request('lastname') . ' updated successfully');
        }

        return view('users.edit', compact('user'));
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
        
    }

    public function template() {
        
    }

    public function notification() {
        $this->data['tasks'] = \App\Models\Task::where('to_user_id', Auth::user()->id)->orderBy('date', 'desc')->get();
        return view('users.notification', $this->data);
    }
}
