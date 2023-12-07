<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendBirhdayWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthdaywishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday wishes to students every day';

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
        if(date('H:i') =='04:40'){
            $schemas = DB::select('select distinct schema_name as table_schema from  shulesoft.setting where schema_name in (select username from admin.clients where status=1 )');
            foreach ($schemas as $schema) {
                // activetots requested  to disable birthday sms
                if (!in_array($schema->table_schema, array('public', 'betatwo', 'api', 'admin', 'activetots'))) {
                    //Remind parents,class and section teachers to wish their students

                    $sql = "insert into shulesoft.sms (schema_name,body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                            . "select '" . $schema->table_schema . "', 'Hello '|| c.name|| ', tunapenda kumtakia '||a.name||' heri ya siku yake ya kuzaliwa katika tarehe '|| a.dob ||'. Mungu ampe afya tele, maisha marefu, baraka na mafanikio.  Kama hajaziliwa tarehe '|| a.dob ||', tuambie tubadili tarehe zake ziwe sahihi. Ubarikiwe',c.phone, 0,0, c.\"parentID\",'parent', (select id from " . $schema->table_schema . ".sms_keys limit 1)  FROM " . $schema->table_schema . ".student a join " . $schema->table_schema . ".student_parents b on b.student_id=a.\"student_id\" JOIN " . $schema->table_schema . ".parent c on c.\"parentID\"=b.parent_id WHERE 
                        DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE) AND a.status = 1 AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE)";
                    DB::statement($sql);

                    //get students with birthday, with their section teacher names
                    //get count total number of students with birthday today and send to admin
                    $sql_for_teachers = "insert into shulesoft.sms (schema_name,body,phone_number,status,type,user_id,\"table\",sms_keys_id)"
                            . "SELECT '" . $schema->table_schema . "', 'Hello '||teacher_name||', leo ni birthday ya '||string_agg(student_name, ', ')||', katika darasa lako '||classes||'('||section||'). Usisite kumtakia heri ya kuzaliwa. Asante', phone,0,0,\"teacherID\",'teacher',(select id from " . $schema->table_schema . ".sms_keys limit 1 ) from ( select a.name as student_name, t.name as teacher_name, t.\"teacherID\", t.phone, c.section, d.classes from " . $schema->table_schema . ".student a join " . $schema->table_schema . ".section c on c.\"sectionID\"=a.\"sectionID\" JOIN " . $schema->table_schema . ".teacher t on t.\"teacherID\"=c.\"teacherID\" join " . $schema->table_schema . ".classes d on d.\"classesID\"=c.\"classesID\" WHERE  a.status=1 and  t.status=1 and  DATE_PART('day', a.dob) = date_part('day', CURRENT_DATE)   AND DATE_PART('month', a.dob) = date_part('month', CURRENT_DATE) ) x GROUP  BY teacher_name,phone,classes,section,phone,\"teacherID\"";
                    DB::statement($sql_for_teachers);
                }
            }
        }
        return 0;
    }
}
