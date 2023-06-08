<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendTodoRemainder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:todoremider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send todo reminder/notificaton';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // run task at 03:40 every day
        if(date('H:i') =='03:40'){
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
        return 0;
    }
}
