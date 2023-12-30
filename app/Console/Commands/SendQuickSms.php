<?php

namespace App\Console\Commands;

// use App\Models\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendQuickSms extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:quicksms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send quick sms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $schemas = DB::select('select * from admin.sms_status a join admin.clients b on b.username=a.schema_name where  message_left >0');
        $total_sms_sent = 0;
        foreach ($schemas as $schema_) {
            $schema = $schema_->schema_name;
            if ($schema_->schema_name == 'public') {
                $messages = DB::select("select a.phone_number as phone, a.body  as body, a.sms_id as id, a.sent_from"
                                . " from public.sms a where a.status = 0 and a.type = 1"
                                . " and sent_from not in ('phonesms','phone-sms') order by priority DESC limit 30");
            } elseif ((int) $schema_->is_new_version == 1) {
                $messages = DB::select("select a.phone_number as phone, a.body  as body, a.sms_id as id, a.sent_from"
                                . " from shulesoft.sms a where a.status = 0 and a.type = 1"
                                . " and sent_from not in ('phonesms','phone-sms') and schema_name='" . $schema . "' order by priority DESC limit 30");
            } else {
                $messages = DB::select("select a.phone_number as phone, a.body  as body, a.sms_id as id, a.sent_from"
                                . " from " . $schema . ".sms a where a.status = 0 and a.type = 1"
                                . " and sent_from not in ('phonesms','phone-sms') order by priority DESC limit 30");
            }

            $total_sms_sent += !empty($messages) ? count($messages) : 0;

            if (!empty($messages)) {
                foreach ($messages as $message) {

                    $beem = $this->beem_sms($message->phone, $message->body, $schema);

                    if ($schema_->schema_name == 'public') {
                        DB::table("public.sms")->where('sms_id', $message->id)->update([
                            'status' => 1,
                            'return_code' => json_encode($beem),
                            'updated_at' => now()
                        ]);
                    } else {
                        $final_schema = (int) $schema_->is_new_version == 1 ? 'shulesoft' : $schema;
                        DB::table($final_schema . ".sms")->where('sms_id', $message->id)->update([
                            'status' => 1,
                            'return_code' => json_encode($beem),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
        Log::info('Quick SMS sent : Total ' . $total_sms_sent . chr(10));
        return 0;
    }

    function beem_sms($phone_number, $message, $schema) {
        return new \App\Http\Controllers\Plugins\BeemSms($phone_number, $message, $schema);
    }

}
