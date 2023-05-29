<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class SendNotice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notices';

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
        if(date('H:i') =='03:40'){
            DB::select('refresh materialized view admin.all_notice');
            $notices = DB::select("select * from admin.all_notice  WHERE  date-CURRENT_DATE=3 and status=0 ");
            ///these are notices
            foreach ($notices as $notice) {
            //$class_ids = (explode(',', preg_replace('/{/', '', preg_replace('/}/', '', $notice->class_id))));
                $to_roll_ids = preg_replace('/{/', '', preg_replace('/}/', '', $notice->to_roll_id));

                $users = $to_roll_ids == 0 ?
                        DB::select("select *,(select id as sms_keys_id from " . $notice->schema_name . ".sms_keys limit 1 ) as sms_keys_id from admin.all_users where 'table' not in ('student', 'setting') AND schema_name::text='" . $notice->schema_name . "'") :
                        DB::select('select *,(select id as sms_keys_id from ' . $notice->schema_name . '.sms_keys limit 1 ) as sms_keys_id from admin.all_users where role_id IN (' . $to_roll_ids . ' ) and schema_name::text=\'' . $notice->schema_name . '\'  ');
                if (count($users) > 0) {
                    foreach ($users as $user) {
                        $message = 'Kalenda ya Shule:'
                                . 'Siku ya tukio : ' . $notice->date . ' ,'
                                . 'Jina la Tukio:  ' . $notice->notice . ','
                                . 'Kwa taarifa zaidi, tembelea akaunti yako ya ShuleSoft. Asante';

                        if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                            DB::statement("insert into " . $notice->schema_name . ".email (email,subject,body) values ('" . $user->email . "', 'Calender Reminder : " . $notice->title . "','" . $message . "')");
                        }
                        if (!empty($user->sms_keys_id)) {
                            DB::statement("insert into " . $notice->schema_name . ".sms (phone_number,body,type,sms_keys_id) values ('" . $user->phone . "','" . $message . "',0," . $user->sms_keys_id . " )");
                        }
                    }
                }
            }
        }
        return 0;
    }
}
