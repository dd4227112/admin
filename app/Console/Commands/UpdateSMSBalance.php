<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Console\Commands\SendQuickSms as quick;
use Illuminate\Support\Facades\Log;


class UpdateSMSBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:sms_balance';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $schemas = DB::select("select  a.client_id, sum(coalesce( a.quantity, 0)) as balance, b.username as schema_name , b.is_new_version from admin.addons_payments a, admin.clients b  where a.client_id =b.id and a.addon_id =2   group by a.client_id, b.username, b.is_new_version  having sum(coalesce( a.quantity, 0)) >0");
        $total_sms_sent = 0;
        // find all customer subscribed to quick sms with their sms balance.
        
        foreach ($schemas as $schema_) {
            $schema = $schema_->schema_name;
            if ($schema_->is_new_version ==1) {
                $messages = DB::select("select a.phone_number as phone, a.body  as body, a.sms_id as id, a.sent_from from shulesoft.sms a where a.status = 1 and a.type = 1 and a.schema_name ='".$schema."'");
            }else {

            $messages = DB::select("select a.phone_number as phone, a.body  as body, a.sms_id as id, a.sent_from from " . $schema . ".sms a where a.status = 1 and a.type = 1");
            }
            $quick = new quick;
            if (!empty($messages)) {
                foreach ($messages as $message) {
                    $total_sms_sent += $quick->countSMS($message->body);
                }
                Log::info($total_sms_sent);
                DB::select(" update admin.sms_balance set balance =balance - ".$total_sms_sent." where client_id =". $schema_->client_id);      
            }
        }
        return 0;
    }
}
