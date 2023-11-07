<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class HRContractRemainders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contractor:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'HR contractor reminder';

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
        if(date('H:i') =='04:40'){   
            $users = DB::select('select * from admin.users where contract_end_date - CURRENT_DATE = 30 and status = 1 and role_id <> 7');
            $hr_officer = \App\Models\User::where(['role_id' => 16, 'status' => 1])->first();
            if (!empty($users)) {
                foreach ($users as $user) {
                    if ($user->contract_end_date < date('Y-m-d')) {
                        $message = 'Hello ' . $hr_officer->firstname . ' ' . $hr_officer->lastname . '.'
                                . chr(10) . 'Employment contract of ' . $user->firstname . ' ' . $user->lastname . ' has already  expired on ' . date('d-m-Y', strtotime($user->contract_end_date)) . '.'
                                . chr(10) . 'Thanks.';
                        $controller = new \App\Http\Controllers\Controller();
                        $controller->send_whatsapp_sms($hr_officer->phone, $message);
                        $controller->send_sms($hr_officer->phone, $message, 1, null, 'admin');
                        $controller->send_email($hr_officer->email, 'Employee Contract', $message);
                    } else {
                        $message = 'Hello HR,' . $hr_officer->firstname . ' ' . $hr_officer->lastname . '.'
                                . chr(10) . 'Employment contract of ' . $user->firstname . ' ' . $user->lastname . ' expected to expire on  ' . date('d-m-Y', strtotime($user->contract_end_date)) . '.'
                                . chr(10) . 'Thanks.';
                        $controller = new \App\Http\Controllers\Controller();
                        $controller->send_whatsapp_sms($hr_officer->phone, $message);
                        $controller->send_sms($hr_officer->phone, $message, 1, null, 'admin');
                        $controller->send_email($hr_officer->email, 'Employee Contract', $message);
                    }
                }
            }
        }
        return 0;
    }
}
