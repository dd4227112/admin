<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendTaskReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send task reminders';

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
        // run task at 04:40 every day
        if(date('H:i') =='04:40'){
            $users = DB::select('select a.activity,a.time,b.email,b.phone, b.name, c.name as client_name from admin.tasks a join admin.users b on a.user_id=b.id join admin.clients c on c.id=a.client_id where date::date=CURRENT_DATE and b.status=1');
            if (!empty($users)) {
                foreach ($users as $user) {
                    $message = 'Hello  ' . $user->name . ' ,'
                            . 'Activity to do: ' . $user->activity . ' for ' . $user->client_name . '. Kindly remember to write all activities in respective profile.  Thanks';
                    DB::statement("insert into public.email (email,subject,body) values ('" . $user->email . "', 'Todays Tasks','" . $message . "')");
                    $key = DB::table('public.sms_keys')->first();
                    DB::statement("insert into public.sms (phone_number,body,type,sms_keys_id) values ('" . $user->phone . "','" . $message . "',0," . $key->id . " )");
                }
            }

        }
        return 0;
    }
}
