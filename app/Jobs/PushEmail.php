<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use DB;

class PushEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
      //  DB::statement("SELECT public.join_all_email()");
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Get List of Emails ready to be sent

        //get list of all schemas

        //loop through schema names and push emails

    $data = DB::select('select * from public.all_email');
    if (!empty($data)) {
        foreach ($data as $message) {
        $data = ['content' => $message->body,'link'=>$message->schema_name,'photo'=>$message->photo,'sitename'=>$message->sitename,'name'=>''];
         $result = Mail::send('email.default', $data, function ($m) use ($message) {
                    $m->from('no-reply@shulesoft.com', $message->sitename);
                    $m->to($message->email)->subject($message->subject);
                });
        if ($result == 1) {
        DB::update('update ' . $message->schema_name. 'email set status=1 WHERE email_id=' . $message->email_id);
        } else {
           DB::update('update ' .$message->schema_name. 'sms set status=0 WHERE email_id=' . $message->email_id);
        }
        }
    } 

    }
}
