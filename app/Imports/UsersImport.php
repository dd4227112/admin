<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
use Auth;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $check = User::where('email', $row[2])->first();
        if(empty($check)){
            $email = $row[2];
        }else{
            $email =  strtolower($row[0].$row[1]).'@shulesoft.com';
        }

        $user = User::create([
            'firstname' => $row[0],
            'lastname' => $row[1],
            'phone' => $row[3],
           'email' => $email,
           'password' => bcrypt($email),
           'role_id' => 20,
           'name' => $row[0] .' '. $row[1],
           'dp' => 'default.png',
           'town' => $row[6],
           'created_by' => Auth::User()->id,
           'photo' => 'default.png',
            'salary' => $row[8],
           'sex' => $row[4],
           'marital' => $row[5],
           'employment_category' => $row[7], //'temporarily',
           'address' => $row[6],
           'date_of_birth' => $row[10],
           'dob' => $row[10],
           'department' => 2,
           'academic_certificates' => $row[9],
        ]);
        if($user){
            $message = 'Hello ' . $user->name . ' You have been added in ShuleSoft Administration panel. You can login for Administration of schools with username ' . $user->email . ' and password ' . $user->email;
            \DB::table('public.sms')->insert([
                'body' => $message,
                'user_id' => 1,
                'phone_number' => $user->phone,
                'table' => 'setting'
            ]);

            \DB::table('public.email')->insert([
                'body' => $message,
                'subject' => 'ShuleSoft Administration Credentials',
                'user_id' => 1,
                'email' => $user->email,
                'table' => 'setting'
            ]); 
        }
        return $user;
    }
}