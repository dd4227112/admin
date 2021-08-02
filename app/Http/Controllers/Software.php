<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Software extends Controller {

    public function __construct() {
        if (!preg_match('/fhodhkjkhdfhoidf/i', request()->segment(1))) {
            $this->middleware('auth');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page = null, $sub = null) {
        $this->data['data'] = ($page == null || in_array($page, array('login'))) ? '' : $this->$page($sub);
        $this->data['page'] = $page;
        $this->data['sub'] = $sub;
        $view = 'software.database.' . strtolower($page);
        if (view()->exists($view)) {
            return view($view, $this->data);
        }
    }

    public function server() {
        $this->data['file'] = '';
        $view = 'software.code_editor';
        if (view()->exists($view)) {
            return view($view, $this->data);
        }
    }

    public function show($id, $sub = null) {
        if ($id == 'compareTable') {
            $this->data['data'] = $this->compareTable();
        } else if ($id == 'syncTable') {
            return $this->syncTable();
        } else if ($id == 'compareColumn') {
            $this->data['data'] = $this->compareColumn();
        }
        $this->data['page'] = $id;
        $this->data['sub'] = $sub;
        $view = 'database.' . strtolower($id);
        if (view()->exists($view)) {
            return view($view, $this->data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function compareTable($schema = null) {
        $this->data['data'] = $this->compareSchemaTables($schema);
        $view = 'software.database.' . strtolower('compareTable');
        if (view()->exists($view)) {
            return view($view, $this->data);
        }
    }

    public function compareColumn($pg = null) {
        $this->data['data'] = DB::select("select * from crosstab('SELECT distinct table_schema,table_type,count(*) FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN (''information_schema'',''pg_catalog'',''information_schema'',''constant'',''admin'',''academy'',''api'') group by table_schema,table_type','select distinct table_type FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN (''information_schema'',''pg_catalog'',''information_schema'',''constant'',''admin'',''dodoso'',''api'',''academy'')')
           AS ct (table_schema text, views text, tables text)");
        $view = 'software.database.' . strtolower('compareColumn');
        if (view()->exists($view)) {
            return view($view, $this->data);
        }
    }

    /**
     * 
     * @param type $table_name
     * @param type $schema_name
     * @constrains types
     *              PRIMARY KEY
     *              CHECK
     *              UNIQUE
     *              FOREIGN KEY
     * 
     * @return type
     */
    public function getConstraint($table_name, $schema_name, $constrains) {
        return DB::select("SELECT * 
FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
WHERE CONSTRAINT_TYPE = '$constrains' 
AND TABLE_NAME = '$table_name' and table_schema='$schema_name'");
    }

    public function getDefinedFunctions() {
        $sql = DB::select("select distinct routine_name from (SELECT routines.routine_name, parameters.data_type, parameters.ordinal_position
        FROM information_schema.routines
            LEFT JOIN information_schema.parameters ON routines.specific_name=parameters.specific_name
        WHERE routines.specific_schema='public'
        ORDER BY routines.routine_name, parameters.ordinal_position ) a");
    }

    public function loadSchema() {
        return DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN ('pg_catalog','information_schema','constant','admin','api','app','skysat','dodoso','forum','academy','carryshop')");
    }

    /**
     * @var Default Schema which is stable
     */
    public static $master_schema = 'beta_testing';

    /**
     * @var $schema : Schema name which we want to know its tables
     * @return List of tables in that schema
     */
    public function loadTables($schema) {
        $tables = DB::select("SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema= '" . $schema . "'  AND table_type='BASE TABLE'");
        $table_names = array();
        foreach ($tables as $table) {
            array_push($table_names, $table->table_name);
        }
        return $table_names;
    }

    /**
     * @var $schema : Schema name which we want to know its table columns
     * @var $table : Table that we want to know its columns
     * @return List of tables in that schema
     */
    public function loadTableColumns($schema, $table) {
        $tables = DB::select("SELECT table_name, column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='" . $schema . "' AND table_name='" . $table . "'");
        $column_names = array();
        foreach ($tables as $table) {
            array_push($column_names, $table->column_name);
        }
        return $column_names;
    }

    public function loadTableColumnsBulks() {
        $tables = DB::select("SELECT table_name, column_name,table_schema FROM INFORMATION_SCHEMA.COLUMNS");
        $column_names = array();
        foreach ($tables as $table) {
            $column_names[$table->table_schema][$table->table_name] = array();
        }

        foreach ($tables as $table) {
            array_push($column_names[$table->table_schema][$table->table_name], $table->column_name);
        }
        return $column_names;
    }

    public function compareSchemaTables($slave_schema = null) {
        $master_tables = $this->loadTables(self::$master_schema);
        $db_file = $this->loadSchema();
        ///$db_file = file_get_contents('app/config/development/db.txt');
        $schemas = $slave_schema == null ? $db_file : array($slave_schema);
        $stable = '<h4>Tables/Views that are missing are as follows</h4>';
        foreach ($schemas as $schema_name) {
            $schema = is_object($schema_name) ? $schema_name->table_schema : $schema_name;
            $slave_tables = $this->loadTables($schema);
            $diff = array_diff($master_tables, $slave_tables);

            $stable .= ' <b>' . $schema . '</b><p>Missing Tables: ' . implode(',', $diff) . ' </p>';

            foreach ($diff as $table) {
                $stable .= "<a href='#'  onclick='return false' data-table='" . $table . "' data-slave='" . $schema . "'  class='sync_table'>Sync <b>" . $table . "</b> Tables</a><br/> <span id='" . $table . $schema . "'></span>";
            }
            $stable .= '<hr/>';
        }
        return $stable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function compareTableColumn($slave_schema = null) {
        $master_tables = $this->loadTables(self::$master_schema);
        $db_file = $this->loadSchema();
        $schemas = $slave_schema == null ? $db_file : array($slave_schema);
        $stable = '';

        foreach ($schemas as $schema_name) {
            //load all column in this main table
            $schema = is_object($schema_name) ? $schema_name->table_schema : $schema_name;
            foreach ($master_tables as $table) {
                # code...
                $master_columns = $this->loadTableColumns(self::$master_schema, $table);
                $slave_columns = $this->loadTableColumns($schema, $table);
                //missing columns
                $missing_columns = array_diff($master_columns, $slave_columns);
                if (!empty($missing_columns)) {
                    $stable .= "Schema Name: " . $schema;
                    $stable .= "<br/>Table Name:" . $table;
                    $stable .= "<br/>Missing columns: " . implode(',', $missing_columns) . '<br/>';
                    foreach ($missing_columns as $column) {
                        $stable .= "<a href='" . url('database/syncColumn?table=' . $table . '&slave=' . $schema . '&column=' . $column) . "'>Sync <b>" . $column . "</b> column</a><br/>";
                    }
                    $stable .= "<br/><hr/>";
                }
            }
        }
        return $stable;
    }

    public function syncTable() {
        $master_table_name = request('table');
        $slave_schema = request('slave');
        $sql = \collect(DB::select("select show_create_table('" . $master_table_name . "','" . $slave_schema . "') as result"))->first();
        return DB::statement(str_replace('ARRAY', 'character varying[]', $sql->result));
    }

    public function syncColumn($master_table = null, $schema = null, $column_missing = null) {
//select from information schema where column name is that which is missing
        //selectfrom information schema table and know data type, default value for that column name
        //complete sql below by adding correct datatype at the end and default column
        $master_table = request('table');
        $schema = request('slave');
        $column_missing = request('column');

        $table_sql = "SELECT column_default,data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='" . self::$master_schema . "' AND table_name='" . $master_table . "' AND column_name='" . $column_missing . "' ";

        $check_table_exists = DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='" . $schema . "' AND table_name='" . $master_table . "' ");
        if (!empty($check_table_exists)) {
            $tb = DB::select($table_sql);
            $table = array_shift($tb);

            $sql = 'ALTER TABLE ' . $schema . '.' . $master_table . ' ADD COLUMN  "' . $column_missing . '"  ' . $table->data_type;
            DB::statement($sql);

            if ($table->column_default != '') {
                $alter_sql = 'ALTER TABLE ' . $schema . '.' . $master_table . ' ALTER COLUMN  "' . $column_missing . '" SET DEFAULT ' . $table->column_default;
                DB::statement($alter_sql);
            } elseif (isset($table->is_nullable) && $table->is_nullable == 'NO') {
                $alter_sql = 'ALTER TABLE ' . $schema . '.' . $master_table . ' ALTER COLUMN  "' . $column_missing . '" SET NOT NULL';
                DB::statement($alter_sql);
            }
        } else {
            echo "This table does not exists in " . $schema . ' schema. Run "background/compareTableColumn"';
        }
        return redirect('software/compareTableColumn/' . $schema);
    }

    public function addIndex() {
        $sql = "SELECT c.oid, c.relname, a.attname, a.attnum, i.indisprimary, i.indisunique
FROM pg_index AS i, pg_class AS c, pg_attribute AS a
WHERE i.indexrelid = c.oid AND i.indexrelid = a.attrelid AND i.indrelid = 'YOURSCHEMA.YOURTABLE'::regclass
ORDER BY c.oid, a.attnum";
    }

    public function upgrade() {
        if (request('sql') != '') {
            $this->data['script'] = $this->createUpgradeScript();
        } else {
            $this->data['script'] = '';
        }
        return view('software.database.upgrade', $this->data);
    }

    public function createUpgradeScript($slave_schema = null) {
        $db_file = request('sql');
        $skip = request('skip');
        $skip_schema = preg_match('/,/', $skip) ? explode(',', $skip) : array($skip);
        $db_schema = $this->loadSchema();
        $schemas = $slave_schema == null ? $db_schema : array($slave_schema);
        $q = '';
        foreach ($schemas as $schema_name) {
            $schema = is_object($schema_name) ? $schema_name->table_schema : $schema_name;
            if (in_array($schema, $skip_schema))
                continue;
            $sql1 = str_replace('testing', $schema, $db_file);
            $sql = preg_replace("/\--[^)]+\--/", "", $sql1);
            $queries = explode(';', $sql);
            foreach ($queries as $query) {
                # code...
                $q .= $query . '; ';
            }
        }
        return $q;
    }

    public function constrains() {
        $type = $this->data['sub'] = request()->segment(3);
        if ($type == 'CHECK') {
            $relations = DB::select('SELECT nspname as "table_schema",conname as constraint_name, replace( conrelid::regclass::text , nspname||\'.\', \'\') AS TABLE_NAME FROM   pg_constraint c JOIN   pg_namespace n ON n.oid = c.connamespace WHERE  contype IN (\'c\') ORDER  BY "nspname"');
        } else {
            $relations = DB::select('SELECT "table_schema", constraint_name,TABLE_NAME FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_TYPE = \'' . $type . '\'  order by "table_schema"');
        }
        $this->data['constrains'] = array();
        foreach ($relations as $table) {
            $this->data['constrains'][$table->table_schema][$table->table_name] = array();
        }

        foreach ($relations as $table) {
            array_push($this->data['constrains'][$table->table_schema][$table->table_name], $table->constraint_name);
        }
        //  return $this->data['constrains'];
        return view('software.database.constrains', $this->data);
    }

    public function getConstrainByName($name) {
        $sql = "SELECT conrelid::regclass AS table_from ,conname ,pg_get_constraintdef(c.oid)
                FROM   pg_constraint c
                JOIN   pg_namespace n ON n.oid = c.connamespace
                WHERE contype IN ('f', 'p ','c','u') AND conname='" . $name . "'
                AND    n.nspname = '" . self::$master_schema . "'
                ORDER  BY conrelid::regclass::text, contype DESC";
        return \collect(DB::select($sql))->first();
    }

    public function syncConstrain() {
        //select from information schema where column name is that which is missing
        //selectfrom information schema table and know data type, default value for that column name
        //complete sql below by adding correct datatype at the end and default column
        $table = request('table');
        $schema = request('slave');
        $constrain = request('constrain');

        $constrain_params = $this->getConstrainByName($constrain);

        if (!empty($constrain_params)) {
            $sql = 'ALTER TABLE ' . $schema . '.' . $table . ' ADD CONSTRAINT  "' . $constrain_params->conname . '"  ' . str_replace(self::$master_schema, $schema, $constrain_params->pg_get_constraintdef);
            DB::statement($sql);
            echo 1;
        } else {
            echo "This table does not exists in " . $schema . ' schema. Run "background/compareTableColumn"';
        }
    }

    public function logs() {
        $this->data['schema_name'] = $schema = request()->segment(3);
        $this->data['error_log_count'] = strlen($schema) > 3 ? DB::table('error_logs')->whereNull('deleted_at')->where('schema_name', $schema)->count() : DB::table('error_logs')->whereNull('deleted_at')->count();
        $this->data['schema_errors']  =  strlen($schema) > 3 ? DB::table('error_logs')->whereNull('deleted_at')->where('schema_name', $schema)->get() : '';
    
        $this->data['danger_schema'] = \collect(DB::select('select count(*), "schema_name" from admin.error_logs  group by "schema_name" order by count desc limit 1 '))->first();
        return view('software.logs', $this->data);
    }

    public function customer_requirement() {
        $schema = request()->segment(3);
        $time = '1 day';
        $where = strlen($schema) > 3 ? ' where "schema_name"=\'' . $schema . '\'  and created_at > now() - interval  \'' . $time . '\'  ' : ' where created_at > now() - interval  \'' . $time . '\' ';
        $this->data['error_logs'] = DB::select('select * from admin.error_logs ' . $where);
        $this->data['danger_schema'] = \collect(DB::select('select count(*), "schema_name" from admin.error_logs  group by "schema_name" order by count desc limit 1 '))->first();
        return view('software.customer_requirement', $this->data);
    }

    public function logsDelete() {
        $id = request('id');
        $tag = \App\Models\ErrorLog::findOrFail($id);

        if (!empty($tag)) {
            $tag->deleted_by = \Auth::user()->id;
            $tag->save();
            $tag->delete();
        }
        echo 1;
    }

    public function Readlogs() {
        $id = request()->segment(3);
        $tag = \App\Models\ErrorLog::findOrFail($id);
        $this->data['schema'] = $schema = $tag->schema_name;
        $this->data['school'] =  $schema != 'public' ? \collect(\DB::select("select * from admin.clients where username = '.$schema.' "))->first() : '';
        $this->data['error_message'] = $tag->error_message . '<br>' . $tag->url . '<br>';
        return view('customer.view', $this->data);
        //echo 1;   
    }

    public function logsView() {
        $type = request('type');
        $this->data['logs'] = DB::select("select * from admin.error_logs where error_instance in (select error_instance from (select error_instance,count(*) from admin.error_logs  group by error_instance having count(*)=" . $type . ") a )  ");
        return view('software.custom_logs', $this->data);
    }

    public function api() {
        if (request('tag')) {
            return $this->ajaxTable('api.requests', ['id', 'content', 'created_at']);
        }
        return view('software.api.requests');
    }

    public function banksetup() {
        $this->data['settings'] = DB::table('admin.all_setting')->get();
        $seg = request()->segment(3);
        $this->data['schema'] = $seg;
        if (strlen($seg) > 2) {
            $this->data['banks'] = DB::select('select b.*,a.api_username,a.api_password,a.invoice_prefix,a.sandbox_api_username,a.sandbox_api_password from ' . $seg . '.bank_accounts_integrations a right join ' . $seg . '.bank_accounts b on a.bank_account_id=b.id');
        }
        return view('software.api.banksetup', $this->data);
    }

    public function setBankParameters() {
        $check = DB::table(request('schema') . '.bank_accounts_integrations')->where('bank_account_id', request('bank_id'));
        if (!empty($check->first())) {
            $check->update([request('tag') => request('val')]);
            DB::statement('UPDATE ' . request('schema') . '.invoices SET "reference"=\'' . request('val') . '\'||"id", prefix=\'' . request('val') . '\'');
            DB::statement('UPDATE ' . request('schema') . '.setting SET "payment_integrated"=1');
            echo 'Records updated successfully';
        } else {
            DB::table(request('schema') . '.bank_accounts_integrations')->insert([
                'bank_account_id' => request('bank_id'),
                request('tag') => request('val')
            ]);
            echo 'Records added successfully';
        }
    }

    public function updateProfile() {
        $schema = request('schema');
        $tag = request('tag');
        $table = request('table');
        $user_id = request('user_id');
        $value = request('val');
        $column = $table == 'student' ? 'student_id' : $table . 'ID';
        if ($table == 'bank') {
            return $this->setBankParameters();
        } else {
            DB::table($schema . '.' . $table)->where($column, $user_id)->update([$tag => $value]);
            if ($tag == 'institution_code') {
                //update existing invoices
                DB::statement('UPDATE ' . $schema . '.invoices SET "reference"=\'' . $value . '\'||"reference"');
            }
            echo 'Records updated successfully ';
        }
    }

    public function invoice($id) {
        if ((int) $id > 0) {
            $this->data['data'] = 1;
            $this->data['results'] = \App\Model\Api_invoice::where('id', $id)
                            ->where('schema_name', request('p'))->get();
            return view('home.invoice_search', $this->data);
        } else {
            $this->data['results'] = DB::select("select * from api.invoices where lower(\"reference\") in (select lower(content->>'invoice') from admin.logs where content->>'invoice' is not null)");
            return view('invoice.searched', $this->data);
//        }else {
//        
//            $sql = 'SELECT * FROM (SELECT * FROM public.crosstab(\'select "schema_name"::text,"table",count(*) from admin.all_users where status=1  group by "schema_name"::text,"table" order by 1,2\', \'select distinct "table"::text from admin.all_users order by 1\') AS final_result("schema_name" text,"parent" text,"setting" text, "student" text, "teacher" text, "user" text) ) a where schema_name=\'' . $id . "'";
//            $this->data['user'] = \collect(\DB::select($sql))->first();
//            $this->data['school'] = $setting = \DB::table($id . '.setting')->first();
//            return view('invoice.show', $this->data);
        }
    }

    public function reconciliation() {
        $this->data['returns'] = [];
        if ($_POST) {
            $schema = request('schema_name');
            $invoices = DB::select('select "schema_name", invoice_prefix as prefix from admin.all_bank_accounts_integrations where "schema_name"=\'' . $schema . '\'');
            $returns = [];
            $background = new \App\Http\Controllers\Background();

            //Find All Payment on This Dates
            $dates = new \DatePeriod(
                    new \DateTime(request('start_date')), new \DateInterval('P1D'), new \DateTime(request('end_date'))
            );
            //To iterate
            foreach ($dates as $key => $value) {

                foreach ($invoices as $invoice) {

                    $token = $background->getToken($invoice);
                    if (strlen($token) > 4) {
                        $fields = array(
                            //  "reconcile_date" => date('d-m-Y', strtotime(request('date'))),
                            "reconcile_date" => $value->format('d-m-Y'),
                            "token" => $token
                        );
                        $push_status = 'reconcilliation';
                        $url = $invoice->schema_name == 'beta_testing' ?
                                'https://wip.mpayafrica.com/v2/' . $push_status : 'https://api.mpayafrica.co.tz/v2/' . $push_status;
                        $curl = $background->curlServer($fields, $url);
                        array_push($returns, json_decode($curl));
                        //  json_decode($curl);
                    } //else { return redirect()->back()->with('success', 'invalid token'); }
                }
            }
            $this->data['returns'] = $returns;
        }
        return view('software.api.reconciliation', $this->data);
    }

    public function syncMissingPayments() {
        $background = new \App\Http\Controllers\Background();
        $url = 'http://51.91.251.252:8081/api/init';
        $fields = json_decode(urldecode(request('data')));
        $curl = $background->curlServer($fields, $url, 'row');
        return $curl;
        // return redirect()->back()->with('success',$curl);
    }

    public function template() {
        $this->data['faqs'] = [];
        return view('software.index', $this->data);
    }

    public function whatsapp() {
        $this->data['faqs'] = [];
        return view('software.whatsapp', $this->data);
    }

    public function requirements() {
        $tab = request()->segment(3);
        $id = request()->segment(4);
        if ($tab == 'show' && $id > 0) {
            $this->data['requirement'] = \App\Models\Requirement::where('id', $id)->first();
            $this->data['next'] = \App\Models\Requirement::whereNotIn('id', [$id])->where('status', 'New')->first()->id;
            return view('customer/view_requirement', $this->data);
        }
        $this->data['levels'] = [];
        if ($_POST) {
            $data = array_merge(request()->all(), ['user_id' => Auth::user()->id]);
            $req = \App\Models\Requirement::create($data);
            if ((int) request('to_user_id') > 0) {

                $user = \App\Models\User::find(request('to_user_id'));
                $message = 'Hello ' . $user->name . '<br/><br/>'
                        . 'There is New School Requirement from ' . $req->school->name . ' (' . $req->school->region . ')'
                        . '<br/><br/><p><b>Requirement:</b> ' . $req->note . '</p>'
                        . '<br/><br/><p><b>By:</b> ' . $req->user->name . '</p>';
                $this->send_email($user->email, 'ShuleSoft New Customer Requirement', $message);
            }
        }
        $this->data['requirements'] = \App\Models\Requirement::orderBy('id', 'DESC')->get();
        return view('software/tasks', $this->data);
    }

    public function updateReq() {
        $id = request('id');
        $action = request('action');
        \App\Models\Requirement::where('id', $id)->update(['status' => $action]);
        return redirect()->back()->with('success', 'success');
    }

    public function addTodo() {
        $id = Auth::user()->id;
        $to = request('to_user_id');
        $message = \App\Models\Chat::create(['body' => request('body'), 'status' => 1]);
        \App\Models\ChatUser::create(['user_id' => $id, 'to_user_id' => $to, 'message_id' => $message->id]);
        $message = '';

        $message .= '<div class="media chat-inner-header">
       <a class="back_chatBox">
       <input id="to_user_id' . $user->id . '" value="' . $user->id . '" type="hidden">
           <i class="icofont icofont-rounded-left"></i>' . $user->firstname . ' ' . $user->lastname . '
         </a>
        </div>';

        echo $message;
    }

    public function smsStatus() {
        $this->data['sms_status'] = \App\Models\SchoolKeys::latest()->get();
        return view('software.status_sms', $this->data);
    }

    /**
     * --work in progress needs to includes all
     *   a) Bugs and errors automatically reported by the application system system (Directly)
     * 
     *    --Once error occur, we will directly add pmp software
     *    
     *   b) Bugs and errors automatically recorded by server logs, which includes nginx, php-fpm, database logs etc
     * 
     *   --we will set a script to run after 30min to check if there is any error recorded
     * 
     *   c) requirements submitted by VP of product and approved by customer success, customers and system users
     * 
     *  -- we will first ensure approval process, requirements must go to vp of product who will authorize and go to success manager will provide the final approval
     *  -- once success manager approve, then it will written to pmp for implementation with a timeline to when the task needs to be accomplished
     * 
     *   d) requirements directly written in projects management software
     * 
     * -- our final update will come from pmp and success manager will verify if this is final work, or else vp of success will specify pending
     */
    public function tasksSummary() {

        $user_id = request()->segment(3);

        //check user
        $user = \App\Models\User::findOrFail($user_id);

//        $project_user = DB::connection('project')->table('users')->where('id', $user_id)->where('email', $user->email)->first();
//
//        if (empty($project_user)) {
//            $project = new \App\Http\Controllers\Project();
//            $project->setUserId($user->email);
//        }
        
        $and = (int) $user_id > 0 ? " AND assign_to in (select id from users where email='" . $user->email. "')": "";
        $projects = DB::connection('project')->select("SELECT a.actual_dt_created as created_at, a.dt_created as last_updated_at,a.due_date,a.title,a.message, b.name as project_name, c.name as task_type, a.type_id, d.name as created_by, e.name as assigned_to, a.user_id,a.project_id,a.assign_to, case when a.legend=1 THEN 'New' when a.legend=2 THEN 'Opened' when a.legend=3 THEN 'Closed' when a.legend=4 THEN 'Start' when a.legend=5 THEN 'Resolve' WHEN a.legend=6 THEN 'Modified' END as final_status, 
CASE 
WHEN reply_type=4 THEN 'High Priority' ELSE 'Default Priority'
END as priority, CASE WHEN status=0 then 'Pending' ELSE 'Closed' END as status FROM `easycases` a JOIN projects b on b.id=a.project_id JOIN types c on c.id=a.type_id JOIN users d on d.id=a.user_id JOIN users
 e on e.id=a.assign_to WHERE a.istype=1 " . $and);

        $this->data['headers'] = \collect($projects)->first();
        $this->data['contents'] = $projects;
        return view('customer.usage.custom_report', $this->data);
    }

}
