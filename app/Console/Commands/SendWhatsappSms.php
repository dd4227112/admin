<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Message;



class SendWhatsappSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a WhatsApp SMS';

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
        $messages = DB::select('select * from admin.whatsapp_messages where status=0 order by id asc limit 29');
        $controller = new \App\Http\Controllers\Controller();
        $total_count = !empty($messages) ? count($messages) : 0;
        foreach ($messages as $message) {
            if (preg_match('/@c.us/i', $message->phone) && strlen($message->phone) < 19) {
                if (!empty($message->company_file_id)) {
                    $file = \App\Models\CompanyFile::find($message->company_file_id);
                    $controller->sendMessageFile($message->phone, $file->path, $file->name, $message->message, $file->extension);
                } else {
                    $controller->sendMessage($message->phone, $message->message);
                }
                DB::table('admin.whatsapp_messages')->where('id', $message->id)->update(['status' => 1, 'updated_at' => now()]);
                //   echo 'message sent to ' . $message->phone . '' . chr(10);
                sleep(0.8);
            } else {
                //this is invalid number, so update in db to show wrong return
                DB::table('admin.whatsapp_messages')->where('id', $message->id)->update(['status' => 1, 'return_message' => 'Wrong phone number supplied', 'updated_at' => now()]);
            }
        }
      //  echo '>> Whatsapp Messages sent : Total sent =' . $total_count . chr(10);
        Log::info('WhatsApp SMS sent : Total ' .$total_count . chr(10));
        //(new Message())->sendEmail();
       return 0;
    }
}
