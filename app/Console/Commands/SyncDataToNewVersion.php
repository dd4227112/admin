<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncDataToNewVersion extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:SyncData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync data to new version';

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

        $client = DB::table('admin.clients')->where('status', 4)->first(); //We transfer one at a time
        // We first set basic data via transfer control
        if (!empty($client)) {
            $control_check = DB::table('admin.transfer_control')->where('schema_name', $client->username)->first();

            if (empty($control_check)) {
                DB::table('admin.transfer_control')->insert(['schema_name' => $client->username]);
            }
            $control = DB::table('admin.transfer_control')->where('schema_name', $client->username)->first();
            if ($control->first_stage == 0) {
                DB::statement("select * from  shulesoft.delete_schema_details_from_shulesoft_schema('$client->username')");
                DB::statement("select * from  shulesoft.transfer_stage_one('$client->username')");
                DB::statement("select * from  shulesoft.transfer_stage_two('$client->username')");

                DB::table('admin.transfer_control')->update(['first_stage' => 1])->where('schema_name', $client->username);
                return true;
            }

            if ($control->second_stage == 0) {
                DB::statement("select * from  shulesoft.transfer_stage_three('$client->username')");
                DB::statement("select * from  shulesoft.transfer_stage_four('$client->username')");
                DB::statement("select * from  shulesoft.transfer_stage_five('$client->username')");
                DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['second_stage' => 1]);
                return true;
            }

            if ($control->third_stage == 0) {
                DB::statement("select * from  shulesoft.transfer_stage_six('$client->username')");
                DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['third_stage' => 1]);
                return true;
            }

            if ($control->fourth_stage == 0) {
                return $this->transferPayments($client);
            }
            if ($control->five_stage == 0) {
                DB::statement("select * from  shulesoft.transfer_stage_seven('$client->username')");
                return DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['five_stage' => 1]);
            }
            if ($control->six_stage == 0) {
                DB::statement("select * from  shulesoft.transfer_stage_eight('$client->username')");
                return DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['six_stage' => 1]);
            }
            if ($control->seven_stage == 0) {
                DB::statement("select * from  shulesoft.transfer_stage_nine('$client->username')");
                return DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['seven_stage' => 1]);
            }
            if ($control->eight_stage == 0) {
                return $this->transferMark($client);
            }

            if ($control->nine_stage == 0) {
                return $this->redistributStudentPayments($client);
            }

            if ($control->ten_stage == 0) {
                return $this->syncJournals($client);
            }
        }
        return 0;
    }

    public function transferPayments($client) {
        //here we need to transfer all payments, and this usually takes a huge time
        /*
         * --We transfer payments into batch, maximum 3000 transactions to prevent db
         * --overloading
         */
        $payment_control = DB::table('admin.transfer_control')->where('schema_name', $client->username)->first();

        $sql = 'INSERT into shulesoft.payments '
                . ' ("student_id","amount","payment_type_id","date","transaction_id",'
                . '"created_at","cheque_number","bank_account_id","payer_name",'
                . '"mobile_transaction_id","transaction_time","account_number","token",'
                . '"reconciled","receipt_code","updated_at","channel",'
                . '"amount_entered","created_by","created_by_table","note","invoice_id",'
                . '"status","sid","priority","comment","uuid","verification_code",'
                . '"verification_url","code",schema_name)'
                . ' select (select student_id from shulesoft.student where  schema_name=\'' . $client->username . '\' and'
                . ' uuid=(select uuid from ' . $client->username . '.student where student_id=a.student_id)),'
                . '"amount","payment_type_id","date","transaction_id","created_at",'
                . '"cheque_number",(select id from shulesoft.bank_accounts where  schema_name=\'' . $client->username . '\' and '
                . ' uuid=(select uuid from ' . $client->username . ' .bank_accounts where'
                . ' id=a.bank_account_id)),"payer_name","mobile_transaction_id",'
                . '"transaction_time","account_number","token","reconciled","receipt_code",'
                . '"updated_at","channel","amount_entered",(select "id" from shulesoft.users where  schema_name=\'' . $client->username . '\' and '
                . ' uuid in (select uuid from ' . $client->username . '.users where "table"=a."created_by_table" and'
                . '  "id"=a."created_by")),"created_by_table","note",'
                . '(select id from shulesoft.invoices where  schema_name=\'' . $client->username . '\' and uuid=(select uuid from ' . $client->username . '.invoices where'
                . ' id=a.invoice_id)),"status","sid","priority","comment","uuid",'
                . '"verification_code","verification_url","code", \'' . $client->username . '\''
                . ' from ' . $client->username . '.payments a where a.uuid not in (select uuid from shulesoft.payments where schema_name=\'' . $client->username . '\' ) order by 1 desc'
                . ' limit 7000';
        DB::statement($sql);
        /*
         * now check if all payments have been transferred, and skip this block completely
         */
        $shulesoft_payments = DB::table('shulesoft.payments')->where('schema_name', $client->username)->count();
        /*
         * update payment offset set existing one plus $shulesoft_payments
         */
        DB::statement("update admin.transfer_control set payment_offset=". $shulesoft_payments." where schema_name='" . $client->username . "'");

        $schema_payments = DB::table($client->username . '.payments')->count();
        if ($schema_payments == $shulesoft_payments) {
            DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['fourth_stage' => 1]);
        }
    }

    public function transferMark($client) {
        //here we need to transfer all marks, and this usually takes a huge time since
        //this table consists of large data object
        /*
         * --We transfer marks into batch, maximum 3000 transactions to prevent db
         * --overloading
         */
        $mark_control = DB::table('admin.transfer_control')->where('schema_name', $client->username)->first();

        $sql = 'INSERT into shulesoft.mark ("examID","exam","student_id","classesID","subjectID",'
                . '"subject","mark","year","created_at","postion","academic_year_id","status",'
                . '"created_by","table","updated_at","uuid",schema_name) select (select "examID" '
                . 'from shulesoft.exam where schema_name=\'' . $client->username . '\' and  uuid=(select uuid from ' . $client->username . '.exam where "examID"=a."examID")),'
                . '"exam",(select student_id from shulesoft.student where  schema_name=\'' . $client->username . '\' AND uuid=(select uuid from'
                . ' ' . $client->username . '.student where student_id=a.student_id)),(select "classesID" from '
                . 'shulesoft.classes where  schema_name=\'' . $client->username . '\' AND uuid=(select uuid from ' . $client->username . '.classes where'
                . ' "classesID"=a."classesID")),(select "subjectID" from shulesoft.subject where  schema_name=\'' . $client->username . '\' AND '
                . 'uuid=(select uuid from ' . $client->username . '.subject where "subjectID"=a."subjectID")),"subject","mark",'
                . '"year","created_at","postion",(select id from shulesoft.academic_year where  schema_name=\'' . $client->username . '\' AND '
                . ' uuid=(select uuid from ' . $client->username . '.academic_year where id=a.academic_year_id)),"status",'
                . '(select "id" from shulesoft.users where  schema_name=\'' . $client->username . '\' AND uuid in (select uuid from ' . $client->username . '.users where'
                . ' "table"=a."table" and  "id"=a."created_by") limit 1),"table","updated_at","uuid",'
                . ' \'' . $client->username . '\' from ' . $client->username . '.mark a where a.uuid not in (select uuid from shulesoft.mark where schema_name=\'' . $client->username . '\' ) '
                . ' order by 1 desc  limit 7000';
        DB::statement($sql);
        /*
         * now check if all payments have been transferred, and skip this block completely
         */
        $shulesoft_marks = DB::table('shulesoft.mark')->where('schema_name', $client->username)->count();
         /*
         * update payment offset set existing one plus count($shulesoft_marks)
         */
        DB::statement("update admin.transfer_control set mark_offset=". $shulesoft_marks." where schema_name='" . $client->username . "'");
       
        
        $schema_marks = DB::table($client->username . '.mark')->count();
        if ($schema_marks == $shulesoft_marks) {
            DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['eight_stage' => 1]);
        }
    }

    public function redistributStudentPayments($client) {
        DB::statement('insert into shulesoft.store_students_id (student_id,schema_name)'
                . 'select student_id,\'' . $client->username . '\' from shulesoft.student where schema_name=\'' . $client->username . '\' and student_id not in (select student_id from shulesoft.store_students_id)');

        $student = DB::table('shulesoft.store_students_id')->where('schema_name', $client->username)->where('status', 0)->first();

        if (empty($student)) {
            DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['nine_stage' => 1]);
        }
        return 0;
    }

    public function syncJournals($client) {
        if (DB::SELECT("SELECT * FROM shulesoft.journal_sync_all('" . $client->username . "')")) {
            DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['ten_stage' => 1]);
            //update major tables
            DB::statement('update shulesoft.salaries a  set user_sid=(select sid from shulesoft.users where schema_name=\'' . $client->username . '\' and  id=a.user_id and "table"=a."table" ) where schema_name=\'' . $client->username . '\' and user_sid is null');
            DB::table('admin.clients')->where('schema_name', $client->username)->update(['status' => 1, 'is_new_version' => 1]);
        }
    }

}
