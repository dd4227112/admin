<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;
use Auth;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $check = User::where('email', $row['email'])->first();
        if(empty($check)){
            $email = $row['email'];
        }else{
            $email =  strtolower($row['firstname'].$row['lastname']).'@shulesoft.com';
        }

        $user = User::create([
           'firstname' => $row['firstname'],
          'lastname' => $row['lastname'],
          'phone' => $row['phone'],
           'email' => $email,
           'password' => bcrypt($email),
           'role_id' => 20,
           'name' => $row['firstname'] .' '. $row['lastname'],
           'dp' => 'default.png',
           'town' => $row['address'],
           'created_by' => Auth::User()->id,
           'photo' => 'default.png',
            'salary' => $row['salary'],
           'sex' => $row['sex'],
           'marital' => $row['marital'],
           'employment_category' => $row['employment_category'], //'temporarily',
           'address' => $row['address'],
           'date_of_birth' => date("Y-m-d", strtotime($row['dob'])),
           'dob' => $row['dob'],
           'department' => 2,
           'academic_certificates' => $row['academic_certificates'],
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