<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StandingOrderRemainder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'standingorder:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set standing order';

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
            $controller = new \App\Http\Controllers\Controller();
            $users = \App\Models\User::where('designation_id', 2)->where('status', 1)->get();
            if (!empty($users)) {
                foreach ($users as $user) {
                    $standingorders = \App\Models\StandingOrder::whereDate('payment_date', \Carbon\Carbon::today())->get();
                    if (!empty($standingorders)) {
                        foreach ($standingorders as $standing) {
                            $message = 'Hello ' . $user->firstname . ' ' . $user->lastname . '.'
                                    . chr(10) . 'Remember to check matured standing order from ' . $standing->client->name
                                    . chr(10) . 'Thanks.';
                            $controller->send_sms($user->phone, $message, 1);
                            $controller->send_whatsapp_sms($user->phone, $message);
                        }
                    }
                }
            }
        }
        return 0;
    }
}
