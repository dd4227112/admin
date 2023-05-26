<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class SendSequenceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sequence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send sequence reminder';

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
        if(true){
            $sequences = \App\Models\Sequence::all();
            foreach ($sequences as $sequence) {
                $users = DB::select("select a.table, a.name,a.username,a.email,a.phone,a.usertype,a.schema_name,a.id,concat(c.firstname,' ',c.lastname ) as csr_name, c.phone as csr_phone from admin.all_users a,admin.users_schools b, admin.users c where b.schema_name=a.schema_name and b.user_id=c.id and a.status=1 and c.status=1 and b.role_id=8 and a.table not in ('parent','student','teacher') and a.id in (select user_id from admin.users_sequences a,admin.sequences
    b where  (a.created_at::date + INTERVAL '" . $sequence->interval . " day')::date=CURRENT_DATE and b.interval=" . $sequence->interval . " )");
                if (count($users) > 0) {
                    foreach ($users as $user) {
                        $replacements = array(
                            $user->name, $user->username, $user->email, $user->phone, $user->usertype
                        );
                        $message = $this->getCleanSms($replacements, $sequence->message) . ''
                                . '. Kwa Msaada Nipigie: ' . $user->csr_name . ' (Account Manager - ' . $user->csr_phone . ')';
                        if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                            DB::table($user->schema_name . ".email")->insert([
                                'email' => $user->email,
                                'subject' => $sequence->title,
                                'body' => $message
                            ]);
                            //DB::statement("insert into " . $user->schema_name . ".email (email,subject,body) values ('" . $user->email . "', '" . $sequence->title . "','" . $message . "')");
                        }
                        $key = DB::table($user->schema_name . '.sms_keys')->first();
                        DB::table('public.sms')->insert([
                            'phone_number' => $user->phone,
                            'body' => $message,
                            'type' => 0,
                            'sms_keys_id' => $key->id
                        ]);
                        // DB::statement("insert into public.sms (phone_number,body,type) values ('" . $user->phone . "','" . $message . "',0)");
                        DB::table('users_sequences')->insert(['user_id' => $user->id, 'table' => $user->table, 'sequence_id' => $sequence->id, 'schema_name' => $user->schema_name
                        ]);
                    }
                }
            }
        }
        return 0;
    }
}
