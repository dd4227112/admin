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

                DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['first_stage' => 1]);
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
        DB::statement("update admin.transfer_control set payment_offset=" . $shulesoft_payments . " where schema_name='" . $client->username . "'");

        $schema_payments = DB::table($client->username . '.payments')->count();
        if ($schema_payments == $shulesoft_payments) {
//            $update_transport = "update shulesoft.tmembers d set"
//                    . " amount=(select a.amount from shulesoft.transport_routes_fees_installments a "
//                    . " where a.schema_name='geniuskings' and a.transport_route_id=d.transport_route_id "
//                    . " and a.schema_name=d.schema_name and a.fees_installment_id  = (select id from "
//                    . " shulesoft.fees_installments where installment_id=d.installment_id "
//                    . " and fee_id=(select id from shulesoft.fees where schema_name='".$client->username."' "
//                    . " and lower(name) like '%transport%' limit 1)) ) "
//                    . " where d.schema_name='".$client->username."' and d.amount::integer <=0";
//            DB::statement($update_transport);
  //          DB::select("select * from shulesoft.selecttransportamount('" . $client->username . "')");
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
        DB::statement("update admin.transfer_control set mark_offset=" . $shulesoft_marks . " where schema_name='" . $client->username . "'");

        $schema_marks = DB::table($client->username . '.mark')->count();
        if ($schema_marks == $shulesoft_marks) {
            DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['eight_stage' => 1]);
        }
    }

    public function redistributStudentPayments($client) {
//        DB::statement('insert into shulesoft.store_students_id (student_id,schema_name)'
//                . 'select student_id,\'' . $client->username . '\' from shulesoft.student where schema_name=\'' . $client->username . '\' and student_id not in (select student_id from shulesoft.store_students_id)');

        DB::statement("select * from shulesoft.transfer_missing_data_into_shulesoft('".$client->username."')");
        
        $student = DB::table('shulesoft.store_students_id')->where('schema_name', $client->username)->where('status', 0)->first();

        if (empty($student)) {
            DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['nine_stage' => 1]);
        }
        return 0;
    }

    public function install_chart_account($client) {
        $predefineds = [
            ['name' => "Banks", 'financial_category_id' => 5, 'predefined' => 1, 'schema_name' => $client->username],
            ['name' => "Cash", 'financial_category_id' => 5, 'predefined' => 1, 'schema_name' => $client->username]];
        foreach ($predefineds as $predefined) {
            $check = \DB::table('shulesoft.account_groups')->where($predefined)->first();
            if (empty($check)) {
                \DB::table('shulesoft.account_groups')->insert($predefined);
                $check = \DB::table('shulesoft.account_groups')->where($predefined)->first();
            }
            if (!empty($check) && $predefined['name'] <> 'Banks') {
                $s_object = ["name" => $check->name, 'schema_name' => $client->username,
                    "financial_category_id" => $check->financial_category_id, "account_group_id" => $check->id];
                DB::table('shulesoft.refer_expense')->where($s_object)->count() == 0 ? DB::table('refer_expense')->insert(array_merge(['code' => rand(1000, 99999), 'predefined' => 1], $s_object)) : '';
            }
        }
    }

    public function syncJournals($client) {
        // if (DB::SELECT("SELECT * FROM shulesoft.journal_sync_all('" . $client->username . "')")) {
        DB::table('admin.transfer_control')->where('schema_name', $client->username)->update(['ten_stage' => 1]);
        //update clients tables
        DB::table('admin.clients')->where('username', $client->username)->update(['status' => 1, 'is_new_version' => 1]);
        DB::statement('update shulesoft.salaries a  set user_sid=(select sid from shulesoft.users where schema_name=\'' . $client->username . '\' and  id=a.user_id and "table"=a."table" ) where schema_name=\'' . $client->username . '\' and user_sid is null');
        $this->install_chart_account($client);
        $this->insertReveneExpense($client);

        DB::SELECT("SELECT * FROM shulesoft.journal_sync_all('" . $client->username . "')");
//}
    }

    public function checkBankDefinition($client) {
             //first check if the bank account id is already in refer expense table or create it
        $banks = DB::table('shulesoft.bank_accounts')->where('schema_name', $client->username)->get();
        foreach ($banks as $bank) {
            $check = DB::table('shulesoft.refer_expense')->where('source_table', 'bank_accounts')
                            ->where('source_id', $bank->id)->first();
            if (empty($check)) {
                $group = DB::table('shulesoft.account_groups')->where('name','ilike','%Banks%')->first();
                $account_group_id = !empty($group) ? $group->id :
                       DB::table('shulesoft.account_groups')->create(['name' => 'Banks', "financial_category_id" => 5, 'predefined' => 1])->id;

                $refer_object = ["name" => $bank->name . '(' . $bank->number . ')',
                    "financial_category_id" => 5,
                    "account_group_id" => $account_group_id,
                    'code' => createCode(),
                    'source_table' => 'bank_accounts',
                    'source_id' => $bank->id,
                    'predefined' => $bank->id];

                return DB::table('shulesoft.refer_expense')->create($refer_object);
            } else {
                return $check;
            }
        }
    }
    public function insertReveneExpense($client) {
        $this->checkBankDefinition($client);
        $sql_revenue = "insert into shulesoft.revenue (uuid,refer_expense_id,account_id,category,transaction_id,reference,amount,user_sid,created_by_sid,note,reconciled, number,sms_sent,date,created_at,updated_at,schema_name,status)
select uuid,refer_expense_id, ( case when bank_account_id is null then (select id from shulesoft.refer_expense where schema_name='" . $client->username . "' and name ilike '%cash%' limit 1) else (select id from shulesoft.refer_expense where schema_name=a.schema_name and source_table='bank_accounts' and source_id=a.bank_account_id) end ),'',transaction_id,invoice_number,amount, (select sid from shulesoft.users where id=a.user_id and \"table\"=a.user_table),(case when created_by_id is null then (select sid from shulesoft.setting where schema_name='" . $client->username . "') else (select sid from shulesoft.users where id=a.created_by_id and \"table\"=a.created_by_table) end ),note,reconciled,number,1,date,created_at,updated_at,'" . $client->username . "',status from shulesoft.revenues a where schema_name='" . $client->username . "'";
        DB::statement($sql_revenue);
        $sql_expense = "insert into shulesoft.expenses 
            (uuid,refer_expense_id,account_id,category,transaction_id,
            reference,amount,vendor_id,created_by_sid,note,reconciled,
            number,date,created_at,updated_at,schema_name,user_name,user_phone,user_sid) select uuid,refer_expense_id,
case when a.bank_account_id is null then 
(select id from shulesoft.refer_expense where name ilike '%cash%' and schema_name=a.schema_name) 
else (select  id from shulesoft.refer_expense where
schema_name=a.schema_name and source_id=a.bank_account_id and source_table='bank_accounts')
end as account_id,\"categoryID\" AS category,transaction_id,ref_no as reference,amount,
(select id from shulesoft.vendors where schema_name=a.schema_name limit 1)
as vendor_id,(select id from shulesoft.users where schema_name=a.schema_name
and \"usertype\"=a.usertype and id=a.\"userID\") as 
created_by_sid,note,reconciled,voucher_no,date,create_date as created_at,
updated_at,schema_name,recipient,uname, (select sid from shulesoft.users where schema_name='" . $client->username . "' and uuid=(select uuid from " . $client->username . ".users where usertype=a.usertype and id=a.\"userID\")) from shulesoft.expense a 
where a.schema_name='" . $client->username . "' and a.uuid not in (select uuid from shulesoft.expenses)";
        DB::statement($sql_expense);
    }

}
