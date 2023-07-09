<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptimizePayment extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payment optimization for each student ';

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

        DB::statement('insert into shulesoft.store_students_id (student_id,schema_name)'
                . 'select student_id,\'' . $client->username . '\' from shulesoft.student where schema_name=\'' . $client->username . '\' and student_id not in (select student_id from shulesoft.store_students_id)');

        $students = DB::table('shulesoft.store_students_id')->where('status', 0)->limit(30)->get();
        //check if all payments has been uploaded
        $shulesoft_payments = DB::table('shulesoft.payments')->where('schema_name', $client->username)->count();
        $schema_payments = DB::table($client->username . '.payments')->count();
        if ($schema_payments != $shulesoft_payments) {
            foreach ($students as $student) {

                if (!empty($student)) {
                    $student_id = $student->student_id;
                    //temporary hard-coded for motherofmercy schema_name
                    if (DB::SELECT("SELECT * FROM shulesoft.redistribute_student_payments($student_id, 'motherofmercy')")) {
                        $update = ['status' => 1];
                        DB::table('shulesoft.store_students_id')->where('student_id', $student_id)->update($update);
                        Log::error("Payment optimization succes for student with student_id " . $student_id);
                    }
                }
            }
        }


        return 0;
    }

}
