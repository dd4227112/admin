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
    private $emails;

    public function __construct()
    {
        // Background process has been started with ID [1] 6915
 
      //  DB::statement("SELECT public.join_all_email()");
       $this->emails=DB::select('select * from admin.all_email');
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

    if (!empty($this->emails)) {
        foreach ($this->emails as $message) {
        $data = ['content' => $message->body,'link'=>$message->schema_name,'photo'=>$message->photo,'sitename'=>$message->sitename,'name'=>''];
         Mail::send('email.default', $data, function ($m) use ($message) {
                    $m->from('no-reply@shulesoft.com', $message->sitename);
                    $m->to($message->email)->subject($message->subject);
                });
         if(count(Mail::failures()) > 0){
        DB::update('update ' . $message->schema_name. '.email set status=0 WHERE email_id=' . $message->email_id);
        } else {
           DB::update('update ' .$message->schema_name. '.email set status=1 WHERE email_id=' . $message->email_id);
        }
        }
    } 

    }
}
