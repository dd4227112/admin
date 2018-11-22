<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Http\Request;
use App\Model\User;
use DB;
use Auth;

class UsersController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $users = User::orderBy('id', 'DESC')->where('created_by', Auth::user()->id)->paginate(6);
        return view('users.index', compact('users'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::where('created_by', Auth::user()->id)->get();
        $users = User::where('created_by', Auth::user()->id)->get();
        return view('users.create', compact('roles', 'users'));
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
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('users.index')
                        ->with('success', 'User ' . $request['firstname'] . ' created successfully');
    }

    public function sendEmailAndSms($request) {
        $message = 'Hello ' . $request->name . ' You have been added in ShuleSoft Administration panel. You can login for Administration of schools with username ' . $request->email . ' and password ' . $request->email;
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
    public function show($id) {
        $user = User::find($id);
        $userRoles = Role::join("role_user", "role_user.role_id", "=", "roles.id")
                ->where("role_user.user_id", $id)
                ->get();

        return view('users.show', compact('user', 'userRoles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::find($id);
        $role = Role::get();
        $userRoles = DB::table("role_user")->where("role_user.user_id", $id)
                        ->pluck('role_user.role_id', 'role_user.role_id')->toArray();

        return view('users.edit', compact('user', 'role', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'phone' => 'required|max:255',
        ]);

        $user = User::find($id);
        $user->firstname = $request['firstname'];
        $user->lastname = $request['lastname'];
        $user->phone = $request['phone'];
        $user->email = $request['email'];
        $user->town = $request['town'];
        $user->save();

        DB::table("role_user")->where("role_user.user_id", $id)
                ->delete();

        foreach ($request->input('role') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('users.index')
                        ->with('success', 'User ' . request('firstname') . ' ' . request('lastname') . ' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::table("users")->where('id', $id)->delete();
        return redirect()->route('users.index')
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
        return view('users.school_account', $this->data);
    }

}
