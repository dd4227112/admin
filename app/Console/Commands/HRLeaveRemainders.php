<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class HRLeaveRemainders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'HR leave Reminders';

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
        $annual = DB::select("select user_id, case when (end_date is null) then joining_date + interval '1 year' else end_date + interval '1 year' end AS annual_date
        from admin.annual_leave");
       $ids = array();
       foreach ($annual as $value) {
           $ids[] = $value->user_id;
       }

       foreach ($annual as $value) {
           if (!is_null($value->annual_date) && date('Y-m-d') == date('Y-m-d', strtotime($value->annual_date . ' - 30 days'))) {
               $users = \App\Models\User::whereIn('id', $ids)->where('status', 1)->whereNotIn('role_id', array(7, 15))->get();
               $hr_officer = \App\Models\User::where(['role_id' => 16, 'status' => 1])->first();
               foreach ($users as $user) {
                   $message = 'Hello '
                           . chr(10) . 'This is the remainder of : ' . $user->firstname . ' ' . $user->lastname . ' is expected to start the annual leave on'
                           . chr(10) . date('d-m-Y', strtotime($value->annual_date . ' + 1 days'))
                           . chr(10) . 'Thanks.';
                   $controller = new \App\Http\Controllers\Controller();
                   $controller->send_whatsapp_sms($hr_officer->phone, $message);
                   $controller->send_sms($hr_officer->phone, $message, 1);
                   $controller->send_email($hr_officer->email, 'Employee Annual leave', $message);
               }
           }
       }
        return 0;
    }
}
