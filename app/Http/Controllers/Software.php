<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Software extends Controller {

    public $source_connection = 'pgsql';
    public $destination_connection = 'pgsql';

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
        $this->data['data'] = ($page == null || in_array($page, array('login'))) ? '' :
                $this->$page($sub);
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
    public function comparetable($schema = 'betatwo') {
        $this->data['data'] = $this->compareSchemaTables($schema);
        $view = 'software.database.' . strtolower('compareTable');
        if (view()->exists($view)) {
            return view($view, $this->data);
        }
    }

    public function compareColumn($pg = null) {
        $this->data['data'] = DB::select("SELECT * FROM public.crosstab('SELECT distinct table_schema,table_type,count(*) FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN (''information_schema'',''pg_catalog'',''api'',''constant'',''admin'',''forum'',''accounts12'',''academy'') group by table_schema,table_type','select distinct table_type FROM INFORMATION_SCHEMA.TABLES WHERE table_schema NOT IN (''information_schema'',''pg_catalog'',''api'',''constant'',''admin'',''forum'',''academy'')') AS ct (table_schema text, views text, tables text)");
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
        return DB::select("SELECT * FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_TYPE = '$constrains' AND TABLE_NAME = '$table_name' and table_schema='$schema_name'");
    }

    public function getDefinedFunctions($schema = 'public') {
        return $sql = DB::select("select distinct routine_name from (SELECT routines.routine_name, parameters.data_type, parameters.ordinal_position
        FROM information_schema.routines
            LEFT JOIN information_schema.parameters ON routines.specific_name=parameters.specific_name
        WHERE routines.specific_schema='$schema'
        ORDER BY routines.routine_name, parameters.ordinal_position ) a");
    }

    /**
     * 
     * @return type array: list of schemas
     */
    public function loadSchema() {
        $schema = self::$master_schema;
        $segment = request()->segment(4);
        $where = strlen($segment) > 3 ? " table_schema='" . $schema . "' AND " : '';

        return DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE $where table_schema NOT IN ('pg_catalog','information_schema','app','skysat','dodoso','forum','academy','accounts12','api','admin','academy','insurance','admin2','projects','constant') order by table_schema asc");
        //return DB::select("SELECT distinct schema_name as table_schema from admin.all_student where extract(year from created_at)=2022 offset 143");
    }

    /**
     * @var Default Schema which is stable
     */
    public static $master_schema = 'public';

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
     * @var $schema : Schema name which we want to know its tables
     * @return List of tables in that schema
     */
    public function loadViews($schema) {
        $tables = DB::select("SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema= '" . $schema . "'  AND table_type<>'BASE TABLE'");
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
        $schema = self::$master_schema;
        $tables = DB::select("SELECT table_name, column_name,table_schema FROM INFORMATION_SCHEMA.COLUMNS where table_schema='" . $schema . "' ");
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
        $slave_schema = null;
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
        $sql = "SELECT FROM admin.show_create_table('" . $master_table_name . "','" . $slave_schema . "')";
        //  return DB::statement($sql);
        // return DB::statement(str_replace('ARRAY', 'character varying[]', $sql->result));
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
        $sql = "SELECT c.oid, c.relname, a.attname, a.attnum, i.indisprimary, i.indisunique FROM pg_index AS i, pg_class AS c, pg_attribute AS aWHERE i.indexrelid = c.oid AND i.indexrelid = a.attrelid AND i.indrelid = 'YOURSCHEMA.YOURTABLE'::regclass ORDER BY c.oid, a.attnum";
    }

    public function upgrade() {
//        $scripts = DB::select('select table_name, (select string_agg(\'"\'||column_name||\'"\',\',\')'
//                        . ' from information_schema.columns  where table_name=p.table_name and table_schema=\'public\' and column_name not in (\'id\') )'
//                        . ' as column_ from information_schema.tables p where p.table_schema=\'shulesoft\''
//                        . ' and p.table_type<>\'VIEW\'');
//        $sql = '';
//        foreach ($scripts as $value) {
//            $sql .= " sql_=format('INSERT into shulesoft.$value->table_name ($value->column_,schema_name)
//	select $value->column_, ''%I'' from %I.$value->table_name',schema_,schema_)";
//            $sql .= '; <br/><br/>execute sql_;<br/><br/>' . chr(10) . chr(10) . '';
//        }
//        echo $sql;
//        exit;
        if (request('sql') != '') {
            $this->data['script'] = $this->createUpgradeScript();
        } else {
            $this->data['script'] = '';
        }
        return view('software.database.upgrade', $this->data);
    }

    public function change() {
        $db_file = request('898uuhihdsdskjddereppok');
        $schemas = $this->loadSchema();
        foreach ($schemas as $schema_name) {
            $schema = is_object($schema_name) ? $schema_name->table_schema : $schema_name;

            $sql1 = str_replace('testing', $schema, $db_file);
            $sql = preg_replace("/\--[^)]+\--/", "", $sql1);
            $queries = explode(';', $sql);
            foreach ($queries as $query) {
                # code...
                $statement = DB::statement($query);
                print_r($statement);
            }
        }
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
                $run_sql = str_replace(';', '', $query);
                //  DB::statement("$query");
                $q .= $query . '; ';
            }
        }
        return $q;
    }

    public function constrains() {
        ///gitset_time_limit(0);
        //ignore_user_abort(true);
        //ini_set('memory_limit', '3000M');
        $type = $this->data['sub'] = request()->segment(3);
        $schema = request()->segment(4);
        if ($type == 'CHECK') {
            $relations = DB::select('SELECT nspname as "table_schema",conname as constraint_name, replace( conrelid::regclass::text , nspname||\'.\', \'\') AS TABLE_NAME FROM   pg_constraint c JOIN   pg_namespace n ON n.oid = c.connamespace WHERE  contype IN (\'c\') ORDER  BY "nspname"');
        } else {
            $relations = DB::select('SELECT "table_schema", constraint_name,TABLE_NAME FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_TYPE = \'' . $type . '\' and "table_schema" in (\'' . $schema . '\',\'public\')  order by "table_schema"');
        }
        $this->data['constrains'] = array();
        foreach ($relations as $table) {
            $this->data['constrains'][$table->table_schema][$table->table_name] = array();
        }

        foreach ($relations as $table) {
            array_push($this->data['constrains'][$table->table_schema][$table->table_name], $table->constraint_name);
        }
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

    public function errorInstanceNotIn() {
        return " not in ('Symfony\Component\HttpKernel\Exception\NotFoundHttpException','Illuminate\Session\TokenMismatchException','Illuminate\Auth\AuthenticationException','Symfony\Component\ErrorHandler\Error\FatalError','ErrorException',
        'BadMethodCallException') ";
    }

    public function logs() {
        $this->data['schema_name'] = $schema = request()->segment(3);
        $year_start = date('Y-01-01');
        $year_end = date('Y-12-01');
        $notIn = $this->errorInstanceNotIn();
        $this->data['error_log_count'] = strlen($schema) > 3 ? \collect(DB::select("select count(*) as total from (SELECT DISTINCT error_message FROM admin.error_logs where deleted_at is null and deleted_by is null and schema_name = '$schema' and extract(year from created_at)= extract(year from current_date) and error_instance $notIn ) as errors"))->first() : \collect(DB::select("select count(*) as total from (SELECT DISTINCT error_message FROM admin.error_logs where deleted_at is null and deleted_by is null and extract(year from created_at)= extract(year from current_date) and error_instance $notIn ) as errors"))->first();
        $this->data['error_log_resolved'] = strlen($schema) > 3 ? \collect(DB::select("select count(*) as total from (SELECT DISTINCT error_message FROM admin.error_logs where deleted_at is not null and deleted_by is not null and schema_name = '$schema' and error_instance $notIn) as resolved"))->first() : \collect(DB::select("select count(*) as total from (SELECT DISTINCT error_message FROM admin.error_logs where deleted_at is not null and deleted_by is not null and error_instance $notIn) as resolved"))->first();
        $this->data['fatal_errors'] = strlen($schema) > 3 ? \collect(\DB::select("select count(*) as total from (SELECT distinct error_message,count(id) as total FROM admin.error_logs where deleted_at is null and deleted_by is null and schema_name = '$schema' and error_instance $notIn group by error_message) as a where a.total > 10"))->first() : \collect(\DB::select("select count(*) as total from (SELECT distinct error_message,count(id) as total FROM admin.error_logs where deleted_at is null and deleted_by is null and error_instance $notIn group by error_message) as a where a.total > 10"))->first();
        $this->data['danger_schema'] = \collect(DB::select('select count(*), "schema_name" from admin.error_logs  group by "schema_name" order by count desc limit 1'))->first();
        $all_errors = strlen($schema) > 3 ? "select  e.error_message,e.max_id,t.error_message,e.total,t.error_instance from (select * from (select distinct error_message,max(id) as max_id,count(id) as total from admin.error_logs where deleted_at is null and deleted_by is null and schema_name = '$schema' and error_instance $notIn  group by error_message) as a ) e
                           join (select * from (SELECT distinct error_message,error_instance FROM admin.error_logs where deleted_at is null and deleted_by is null and schema_name = '$schema' and error_instance $notIn group by error_instance,error_message,created_at::date) as a) t on e.error_message = t.error_message" :
                "select  e.error_message,e.max_id,t.error_message,e.total,t.error_instance from (select * from (select distinct error_message,max(id) as max_id,count(id) as total from admin.error_logs where deleted_at is null and deleted_by is null and error_instance $notIn  group by error_message) as a ) e
                           join (select * from (SELECT distinct error_message,error_instance FROM admin.error_logs where deleted_at is null and deleted_by is null and error_instance $notIn group by error_instance,error_message,created_at::date) as a) t on e.error_message = t.error_message";
        $sql1 = strlen($schema) > 3 ? "select mon.mon, coalesce(s.count, 0) as count from generate_series('{$year_start}'::timestamp, '{$year_end}'::timestamp, interval '1 month') as mon(mon) left join (select date_trunc('Month', created_at) as month,count(distinct error_message) as count from  admin.error_logs where extract(year from created_at) = extract(year from current_date) and schema_name = '$schema' and error_instance $notIn group by month ) s on mon.mon = s.month" : "select mon.mon, coalesce(s.count, 0) as count from generate_series('{$year_start}'::timestamp, '{$year_end}'::timestamp, interval '1 month') as mon(mon) left join (select date_trunc('Month', created_at) as month,count(distinct error_message) as count from  admin.error_logs where extract(year from created_at) = extract(year from current_date) and error_instance $notIn group by month ) s on mon.mon = s.month";
        $sql2 = strlen($schema) > 3 ? "select mon.mon, coalesce(s.count, 0) as count from generate_series('{$year_start}'::timestamp, '{$year_end}'::timestamp, interval '1 month') as mon(mon) left join (select date_trunc('Month', created_at) as month,count(distinct error_message) as count from  admin.error_logs where deleted_at is not null and deleted_by is not null and extract(year from created_at)= extract(year from current_date) and schema_name = '$schema' and error_instance $notIn group by month ) s on mon.mon = s.month" : "select mon.mon, coalesce(s.count, 0) as count from generate_series('{$year_start}'::timestamp, '{$year_end}'::timestamp, interval '1 month') as mon(mon) left join (select date_trunc('Month', created_at) as month,count(distinct error_message) as count from  admin.error_logs where deleted_at is not null and deleted_by is not null and extract(year from created_at)= extract(year from current_date)  and error_instance $notIn group by month ) s on mon.mon = s.month";
        $sql3 = strlen($schema) > 3 ? "select mon.mon, coalesce(s.count, 0) as count from generate_series('{$year_start}'::timestamp, '{$year_end}'::timestamp, interval '1 month') as mon(mon) left join (select date_trunc('Month', created_at) as month,count(distinct error_message) as count from  admin.error_logs where deleted_at is null and deleted_by is null and extract(year from created_at)= extract(year from current_date) and schema_name = '$schema' and error_instance $notIn group by month ) s on mon.mon = s.month" : "select mon.mon, coalesce(s.count, 0) as count from generate_series('{$year_start}'::timestamp, '{$year_end}'::timestamp, interval '1 month') as mon(mon) left join (select date_trunc('Month', created_at) as month,count(distinct error_message) as count from  admin.error_logs where deleted_at is null and deleted_by is null and extract(year from created_at)= extract(year from current_date)  and error_instance $notIn group by month ) s on mon.mon = s.month";

        $this->data['all_errors'] = \DB::select($all_errors);
        $this->data['monthly_errors'] = \DB::select($sql1);
        $this->data['monthly_solved'] = \DB::select($sql2);
        $this->data['monthly_unsolved'] = \DB::select($sql3);
        return view('software.error_logs', $this->data);
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
        $tag = \App\Models\ErrorLog::find($id);
        if (isset($tag->error_message)) {
            $update = \DB::table('admin.error_logs')->where('error_message', '=', $tag->error_message)->update(['deleted_at' => now(), 'deleted_by' => \Auth::user()->id]);
            echo $update > 0 ? 1 : 0;
        }
    }

    public function Readlogs() {
        $this->data['id'] = $id = request()->segment(3);
        $this->data['schema'] = $schema = request()->segment(4);
        $this->data['tag'] = $tag = \App\Models\ErrorLog::find($id);
        $this->data['errors'] = $errors = strlen($schema) > 3 ? \App\Models\ErrorLog::where(['error_message' => $tag->error_message, 'schema_name' => $tag->schema_name])->whereNull(['deleted_at', 'deleted_by'])->latest()->get() : \App\Models\ErrorLog::where('error_message', $tag->error_message)->whereNull(['deleted_at', 'deleted_by'])->latest()->get();
        $this->data['school'] = strlen($schema) > 3 ? \collect(\DB::select("select name from admin.clients where username = '$schema' "))->first() : [];

        $this->data['error_message'] = $tag->error_message . '<br>' . $tag->url . '<br>';
        return view('software.logs', $this->data);
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
        $this->data['status'] = [];
        return view('software.api.requests', $this->data);
    }

    public function loadaccounts() {
        $schema = request('schema');
        if (strlen($schema) > 2) {
            $this->data['banks'] = $banks = DB::select('select b.id as account_id,b.number from ' . $schema . '.bank_accounts b');
        }
        if (!empty($banks)) {
            echo '<option value="">select account</option>';
            foreach ($banks as $value) {
                echo '<option value="' . $value->account_id . '">' . $value->number . '</option>';
            }
        } else {
            echo "0";
        }
    }

    public function loadcredentials() {
        $schema_name = request('schema_name');
        $account_id = request('account_id');
        if (strlen($schema_name) > 2) {
            $this->data['settings'] = DB::table('admin.all_setting')->get();
            $this->data['details'] = \collect(\DB::select('select b.id as account_id,b.number,a.api_username,a.api_password,a.invoice_prefix,a.sandbox_api_username,a.sandbox_api_password from ' . $schema_name . '.bank_accounts_integrations a right join ' . $schema_name . '.bank_accounts b on a.bank_account_id=b.id  where b.id = ' . $account_id . '  '))->first();
            echo ($this->data['details']);
            // return view('software.api.bank_setup', $this->data);
        }
    }

    public function UpdateInt() {
        if ($_POST) {
            $this->setBankParameters();
            $this->assignAndNotifications();
            DB::statement('REFRESH MATERIALIZED VIEW admin.all_bank_accounts_integrations');
            return redirect()->back()->with('success', 'Successfully integrated!');
        }
    }

    public function banksetup() {
        $this->data['settings'] = DB::table('admin.all_setting')->get();
        $skip = ['beta_testing', 'betatwo', 'public', 'constant', 'api'];
        $this->data['integrations'] = DB::table('admin.all_bank_accounts_integrations')->whereNotIn('schema_name', $skip)->get();
        return view('software.api.bank_setup', $this->data);
    }

    public function setBankParameters() {
        $check = DB::table(request('schema') . '.bank_accounts_integrations')->where('bank_account_id', request('bank_id'));
        if (!empty($check->first())) {
            $check->update(['api_username' => request('api_username'), 'invoice_prefix' => request('invoice_prefix'), 'api_password' => request('api_password'), 'updated_at' => now()]);
            DB::statement('UPDATE ' . request('schema') . '.invoices SET "reference"=\'' . request('invoice_prefix') . '\'||"id", prefix=\'' . request('invoice_prefix') . '\'');
            DB::statement('UPDATE ' . request('schema') . '.setting SET "payment_integrated"=1');
            // echo 'Records updated successfully';
        } else {
            DB::table(request('schema') . '.bank_accounts_integrations')->insert([
                'bank_account_id' => request('bank_id'),
                'api_username' => request('api_username'),
                'invoice_prefix' => request('invoice_prefix'),
                'api_password' => request('api_password')
            ]);
            DB::statement('UPDATE ' . request('schema') . '.invoices SET "reference"=\'' . request('invoice_prefix') . '\'||"id", prefix=\'' . request('invoice_prefix') . '\'');
            DB::statement('UPDATE ' . request('schema') . '.setting SET "payment_integrated"=1');
            //  echo 'Records added successfully';
        }
    }

    public function assignAndNotifications() {
        //send email to shulesoft personel
        $bank_id = (int) request('bank_id');
        $schema = request('schema');
        $client = DB::table('admin.clients')->where('username', $schema)->first();

        if ((int) request('bank_id') > 0) {
            $bank = \collect(\DB::select("select a.* from $schema.bank_accounts a join constant.refer_banks b on a.refer_bank_id = b.id where a.id = '$bank_id' "))->first();
            if ($bank->refer_bank_id == '8') {  // CRDB Mr Pallangyo, for now  adding manually
                $bank_name = 'CRDB';
                $user = \App\Models\User::find(761);
                $this->assignTask($user, $client, $bank_name);
            } else if ($bank->refer_bank_id == '22') { // NMB Mr Endobile, 764
                $bank_name = 'NMB';
                $user = \App\Models\User::find(764);
                $this->assignTask($user, $client, $bank_name);
            }

            if (!empty($user)) {
                $message = 'Habari hatua za integration katika shule ya ' . \App\Models\Client::where('id', $client->id)->first()->name . ' na bank ya ' . $bank_name . ' zimekamilika tafadhali endelea na hatua zinazofata,ASANTE.';
                $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
            }
        }

        // send to zone manager of school
        $sales = new \App\Http\Controllers\Customer();
        $m_user = $sales->zonemanager($client->id);
        if (!empty($m_user)) {
            $manager = \App\Models\User::where('id', $m_user->user_id)->first();
            $manager_message = 'habari ' . $manager->firstname . '<br/>'
                    . ' hatua za integration katika shule ya'
                    . '<li>' . \App\Models\Client::where('id', $client->id)->first()->name . '</li>'
                    . ' zimekamilika tafadhali wasiliana na bank product associate kutoka'
                    . ' shulesoft aweze kuwapa taarifa shule husika na kuendelea'
                    . ' nao katika hatua zinazofata, ASANTE.';
            $this->send_email($manager->email, 'ShuleSoft Task Allocation', $manager_message);

            $fullname = $manager->firstname . " " . $manager->lastname;
            $message = "habari " . $fullname . " Hatua za integration katika shule ya " . \App\Models\Client::where('id', $client->id)->first()->name . " zimekamilika Tafadhali wasiliana na bank product associate kutoka shulesoft aweze kuwapa taarifa shule husika na kuendelea nao katika hatua zinazofata,ASANTE";
            $this->send_whatsapp_sms($manager->phone, $message);
        }

        //send sms to Admins/Directors of schools
        $users = DB::table($schema . '.users')->where('usertype', 'ILIKE', "%Admin%")->get();
        if (isset($users) && count($users) > 0) {
            foreach ($users as $user) {
                $message = 'Habari, ningependa kukujulisha kuwa sasa shule yako ' . \App\Models\Client::where('id', $client->id)->first()->name . ' hatua za integration na bank ya ' . $bank_name . ' zimekamilika na  unaweza kupata control number kutoka kwenye invoice ya mwanafunzi husika kupitia system ya shulesoft.kwa maelezo zaidi namna ya kulipia na kutuma sms kwenda kwa wazazi mtaalmu toka shulesoft atakupigia akuelekeze katika hatua hizo. Asante.';
                $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
                $this->send_whatsapp_sms($user->phone, $message);
            }
        }
    }

    public function assignTask($user, $client, $bank) {
        $user = (object) $user;
        $section = \App\Models\TrainItem::where('status', 1)->where('content', 'ILIKE', "%" . $bank . "%")->first();
        $this->locateTask($section->id, $section->content, $section->time, $user->id, $client);
    }

    public function locateTask($sectionid, $content, $time, $user_id, $client) {
        $slot = \App\Models\Slot::first();
        $start_date = date('Y-m-d');

        $data = [
            'activity' => $content,
            'date' => $start_date,
            'user_id' => $user_id,
            'task_type_id' => preg_match('/data/i', $content) ? 3 : 4,
            'start_date' => date('Y-m-d H:i', strtotime($start_date)),
            'end_date' => date('Y-m-d H:i', strtotime($start_date . " + {$time} days")),
            'slot_id' => (int) $slot->id > 0 ? $slot->id : 5
        ];

        $task = \App\Models\Task::create($data);
        DB::table('tasks_users')->insert([
            'task_id' => $task->id,
            'user_id' => (int) $user_id,
        ]);

        DB::table('tasks_clients')->insert([
            'task_id' => $task->id,
            'client_id' => (int) $client->id
        ]);

        if ($sectionid != '') {
            \App\Models\TrainItemAllocation::create([
                'task_id' => $task->id,
                'client_id' => $client->id,
                'user_id' => $user_id,
                'train_item_id' => $sectionid,
                'school_person_allocated' => '',
                'max_time' => $time
            ]);
        }
    }

    public function updateintegration() {
        $schema = request()->segment(3);
        $account_id = request()->segment(4);
        $where = ['bank_account_id' => $account_id];
        $this->data['school'] = DB::table('admin.clients')->where('username', $schema)->first();
        //$bank_integration = DB::table($schema.'.bank_accounts_integrations')->where($where)->first();
        $this->data['check'] = \collect(\DB::select('select b.id as account_id,b.name,b.number,a.api_username,a.api_password,a.invoice_prefix,a.sandbox_api_username,a.sandbox_api_password from ' . $schema . '.bank_accounts_integrations a right join ' . $schema . '.bank_accounts b on a.bank_account_id=b.id'))->first();

        if ($_POST) {
            $update = ['api_username' => request('api_username'), 'invoice_prefix' => request('invoice_prefix'), 'api_password' => request('api_password'), 'updated_at' => now()];
            $bank_integration = DB::table($schema . '.bank_accounts_integrations')->where($where);
            $bank_integration->update($update);

            DB::statement('UPDATE ' . $schema . '.invoices SET "reference"=\'' . request('invoice_prefix') . '\'||"id", prefix=\'' . request('invoice_prefix') . '\'');
            DB::statement('UPDATE ' . $schema . '.setting SET "payment_integrated"=1');
            DB::statement('REFRESH MATERIALIZED VIEW admin.all_bank_accounts_integrations');

            return redirect('software/banksetup')->with('success', 'Updated successfully');
        }
        return view('software.api.edit_setup', $this->data);
    }

    public function updateProfile() {
        $schema = request('schema');
        $tag = request('tag');
        $table = request('table');
        $user_id = request('user_id');
        $value = request('val');
        $column = $table == 'student' ? 'student_id' : $table . 'ID';

        //  dd($value);
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
        $this->data['prefix'] = '';
        if ($_POST) {
            $schema = request('schema_name');
            // echo 3535335;
            $invoices = DB::select('select "schema_name", invoice_prefix as prefix from admin.all_bank_accounts_integrations where api_username is not null and api_password is not null and "schema_name"=\'' . $schema . '\'');
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
                    $this->data['prefix'] = $invoice->prefix;
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
        $url = 'http://75.119.140.177:8081/api/init';
        $fields = json_decode(urldecode(request('data')));
        $curl = $background->curlServer($fields, $url);
        return $curl;
        // return redirect()->back()->with('success',$curl);
    }

    public function syncPayments($data) {
        $background = new \App\Http\Controllers\Background();
        $url = 'http://51.91.251.252:8081/api/init';
        $fields = $data;
        $curl = $background->curlServer($fields, $url, 'row');
        return $curl;
    }

    public function template() {
        $this->data['faqs'] = [];
        return view('software.index', $this->data);
    }

    public function whatsapp() {
        $data = ['id' => 1, 'name' => "albo"];
        //  dd(json_encode($data));
        $dr = '{"status":0,"reference":"SAS8003699","description":"This invoice does not exists in the ShuleSoft"}';
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
        return view('software.smsstatus', $this->data);
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
        $date_from = request()->segment(4);
        $and = '';
        if ((int) $user_id > 0) {
            $user = \App\Models\User::findOrFail($user_id);
            $and = (int) $user_id > 0 ? " AND assign_to in (select id from users where email='" . $user->email . "')" : "";
        }
        $and_where = '';
        if (isset($date_from) && strlen($date_from) > 4) {
            $and_where = " AND a.actual_dt_created>='" . date('Y-m-d', strtotime($date_from)) . "'";
        }

        $projects = DB::connection('project')->select("SELECT a.actual_dt_created as created_at, a.dt_created as last_updated_at,a.due_date,a.title,a.message, b.name as project_name, c.name as task_type, a.type_id, d.name as created_by, e.name as assigned_to, a.user_id,a.project_id,a.assign_to, case when a.legend=1 THEN 'New' when a.legend=2 THEN 'Opened' when a.legend=3 THEN 'Closed' when a.legend=4 THEN 'Start' when a.legend=5 THEN 'Resolve' WHEN a.legend=6 THEN 'Modified' END as final_status, 
            CASE 
            WHEN reply_type=4 THEN 'High Priority' ELSE 'Default Priority'
            END as priority, CASE WHEN status=0 then 'Pending' ELSE 'Closed' END as status FROM `easycases` a JOIN projects b on b.id=a.project_id JOIN types c on c.id=a.type_id JOIN users d on d.id=a.user_id JOIN users
            e on e.id=a.assign_to WHERE a.istype=1 " . $and . $and_where);

        $this->data['headers'] = \collect($projects)->first();
        $this->data['contents'] = $projects;

        return view('customer.usage.custom_report', $this->data);
    }

    public function myLogs() {
        $this->data['logs'] = DB::SELECT("select * from admin.error_logs a WHERE a.deleted_at is null AND (a.route like '%mark%' OR a.route like '%exam%' OR a.route like '%classes%' OR a.route like '%subject%' OR a.route like '%routine%' OR a.route like '%semester%' OR a.route like '%student%' OR a.route like '%parent%' OR a.route like '%user%') order by id asc limit 200");
        return view('software.mylogs', $this->data);
    }

    //   id	error_message	file	route	url	error_instance	request	schema_name	created_by	created_by_table	created_at

    public function statisticsd() {
        $this->data['first_day'] = $first_day = date("Y-m-d", strtotime('monday this week'));
        $this->data['end_week'] = $end_week = date('Y-m-d', strtotime($first_day . ' + 6 days'));
        $notIn = $this->errorInstanceNotIn();

        $all_errors = "SELECT error_message,COUNT(error_message) as error_count FROM admin.error_logs WHERE created_at::date >= '{$first_day}' and created_at::date <= '{$end_week}' AND error_instance $notIn GROUP BY error_message";
        $this->data['weekly_errors'] = \DB::select($all_errors);

        if ($_POST) {
            $this->data['first_day'] = $first_day = date('Y-m-d', strtotime(request('week')));
            $this->data['end_week'] = $end_week = date('Y-m-d', strtotime($first_day . ' + 6 days'));
            $all_errors = "SELECT error_message,COUNT(error_message) as error_count FROM admin.error_logs WHERE created_at::date >= '{$first_day}' and created_at::date <= '{$end_week}' AND error_instance $notIn GROUP BY error_message";
            $this->data['weekly_errors'] = \DB::select($all_errors);
        }

        return view('software.error_statistics', $this->data);
    }

    public function statistics() {
        $errors_array = [
            'Invalid datetime format',
            'Invalid text representation',
            'Trying to get property',
            'Deadlock detected',
            'Undefined variable',
            'Undefined function',
            'Call to undefined function',
            'Call to a member function',
            'Datatype mismatch',
            'Foreign key violation',
            'Unique violation',
            'Too Many Attempts',
            'The given data was invalid',
            'No query results for model',
            'Argument 1 passed to',
            'Parameter must be an array or an object',
            'Division by zero',
            'does not exist on this collection instance'
        ];

        $this->data['first_day'] = $first_day = date("Y-m-d", strtotime('monday this week'));
        $this->data['end_week'] = $end_week = date('Y-m-d', strtotime($first_day . ' + 6 days'));

        if ($_POST) {
            $this->data['first_day'] = $first_day = date('Y-m-d', strtotime(request('week')));
            $this->data['end_week'] = $end_week = date('Y-m-d', strtotime($first_day . ' + 6 days'));

            $final = [];
            foreach ($errors_array as $field => $value) {
                $solved_error_count = DB::table('admin.error_logs')->where('created_at', '>=', $first_day)->where('created_at', '<=', $end_week)->where('error_message', 'ILIKE', "%${value}%")->whereNotNull('deleted_at')->count();
                $error_count = DB::table('admin.error_logs')->where('created_at', '>=', $first_day)->where('created_at', '<=', $end_week)->where('error_message', 'ILIKE', "%${value}%")->whereNull('deleted_at')->count();

                $data = [
                    'message' => $value,
                    'error_count' => $error_count,
                    'solved_error_count' => $solved_error_count
                ];
                array_push($final, $data);
            }
            $this->data['finals'] = $final;
        }
        return view('software.error_statistics', $this->data);
    }

    public function resetPassword() {
        if ($_POST) {
            $schema = request('schema');
            $pass = $schema . rand(5697, 33);
            $username = $schema . date('Hi');

            $query1 = DB::select("select * from admin.all_setting where schema_name ='$schema'");
            $query2 = DB::select("select * from shulesoft.setting where schema_name = '$schema'");

            $available_in_admin = \collect($query1)->first();
            $available_in_shulesoft = \collect($query2)->first();
            if ($available_in_shulesoft) {
                DB::table('shulesoft.setting')->where('schema_name', $schema)->update(['password' => bcrypt($pass), 'username' => $username]);
                $this->data['school'] = DB::table('shulesoft.setting')->where('schema_name', $schema)->first();
            }
            if ($available_in_admin) {
                DB::table($schema . '.setting')->update(['password' => bcrypt($pass), 'username' => $username]);
                $this->data['school'] = DB::table($schema . '.setting')->first();
            }

            $this->data['schema_name'] = $schema;
            $this->data['pass'] = $pass;
            $this->data['username'] = $username;
            return view('software.reset_pass', $this->data)->with('success', 'Password Updated Successfully');
        } else {
            return view('software.reset_pass');
        }
    }

    public function transferDb() {
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '3000M');
        $source_connection = 'pgsql';
        $destination_connection = $this->destination_connection;

        //load all schemas
        //$schemas = $this->loadSchema();
        $schemas = (object) array('table_schema' => ['table_schema' => request('s')]);
        $skip_schemas = ['admin', 'api'];
        //loop throught schemas, and load all tables, views and functions
        foreach ($schemas as $schema_) {
            $schema = (object) $schema_;
            if (in_array($schema->table_schema, $skip_schemas)) {
                continue;
            }
            DB::connection($destination_connection)->statement('create schema IF NOT EXISTS ' . $schema->table_schema);
            echo 'Schema ' . $schema->table_schema . ' created successfully in new db ' . $destination_connection . '<br/>';

            $tables = $this->loadTables($schema->table_schema);
            $skip_poor_tables = ['school_sessions', 'financial_statement', 'student_other',
                'financial_category', 'migrations', 'allschools', 'password_resets',
                'phone_sms', 'reminder_template', 'permission_group',
                'adjustments', 'journal', 'ledger', 'courses', 'portal_roles'];
            foreach ($tables as $table) {

                if (in_array($table, $skip_poor_tables)) {
                    continue;
                }

                //show table
                $sql = "SELECT * FROM admin.show_create_table('" . $table . "','" . $schema->table_schema . "')";
                $check = DB::select($sql);
                $show_create_table = \collect($check)->first()->show_create_table;

                if (strlen($show_create_table) > 10) {
                    //create a new table in a secondary table

                    $check_table = \collect(DB::connection($destination_connection)->select("SELECT table_schema 
FROM information_schema.tables
WHERE table_schema ='{$schema->table_schema}'
      AND table_name = '" . $table . "'"))->first();

                    if (empty($check_table)) {

                        DB::connection($destination_connection)->statement(str_replace('ARRAY', 'character varying[]', $show_create_table));
                        echo 'Table  ' . $table . ' created successfully in new db ' . $destination_connection . '<br/>';
                        //transfer data from old to new connection 

                        if ($table == 'allowances') {
                            DB::connection($destination_connection)->statement('ALTER TABLE ' . $schema->table_schema . '.allowances
    ALTER COLUMN is_percentage TYPE integer USING is_percentage::integer;');
                        }

                        if ($table == 'allowances1') {
                            DB::connection($destination_connection)->statement('ALTER TABLE ' . $schema->table_schema . '.allowances1
    ALTER COLUMN is_percentage TYPE integer USING is_percentage::integer;');
                        }
                        if ($table == 'deductions') {
                            DB::connection($destination_connection)->statement('ALTER TABLE ' . $schema->table_schema . '.deductions
    ALTER COLUMN is_percentage TYPE integer USING is_percentage::integer;');
                        }
                        if ($table == 'forum_discussion') {
                            /// DB::connection($destination_connection)->statement('ALTER TABLE ' . $schema->table_schema . '.forum_discussion
                            //ALTER COLUMN sticky TYPE integer USING sticky::integer;');
//                              DB::connection($destination_connection)->statement('ALTER TABLE ' . $schema->table_schema . '.forum_discussion
//    ALTER COLUMN answered TYPE integer USING answered::integer;');
                        }
                        if ($table == 'forum_post') {
                            //DB::connection($destination_connection)->statement('ALTER TABLE ' . $schema->table_schema . '.forum_post
                            //ALTER COLUMN markdown TYPE integer USING markdown::integer;');
//                             DB::connection($destination_connection)->statement('ALTER TABLE ' . $schema->table_schema . '.forum_post
//    ALTER COLUMN locked TYPE integer USING locked::integer;');
                        }

                        $old_table_data = DB::table($schema->table_schema . '.' . $table)->get();

                        if (!empty($old_table_data)) {
                            foreach ($old_table_data as $value) {

                                DB::connection($destination_connection)->table($schema->table_schema . '.' . $table)->insert((array) $value);
                            }
                        }
                        echo 'Data inserted in a table  ' . $table . '  successfully in new db ' . $destination_connection . '<br/>';
                    } else {
                        echo 'Table exists, information skipped<br/>';
                    }
                } else {
                    echo '<p style="color:red">Table ' . $table . ' is Empty, and cannot generate a query</p><br/>';
                }
                sleep(0.5);
            }

            //lets deal with functions
            $s = 1;
            if ($s == 1) {
                $functions = $this->getDefinedFunctions($schema->table_schema);

                foreach ($functions as $function) {

                    $sql = \collect(DB::select("SELECT pg_get_functiondef(( SELECT  oid FROM pg_proc  WHERE  proname = '{$function->routine_name}' and lower(prosrc) like '%public%' limit 1) )"))->first();
                    if ($sql->pg_get_functiondef <> '') {
                        DB::connection($destination_connection)->statement(str_replace('public', $schema->table_schema, $sql->pg_get_functiondef));
                        echo 'Function  ' . $function->routine_name . ' created successfully in new db ' . $destination_connection . ' for schema ' . $schema->table_schema . '<br/>';
                    }
                }
                echo 'SCHEMA ' . $schema->table_schema . ' TRANSFERRED COMPLETELY <br/><br/><hr/>';
            }

            // $this->resetSequence();
            $this->createIndexSchema(request('s'));
        }
    }

    public function syncViews($schema, $destination_connection) {
        $views = $this->loadViews($schema->table_schema);

        foreach ($views as $view) {
            //show table
            $sq = "select pg_get_viewdef('$schema->table_schema.$view')";
            $sql = \collect(DB::select($sq))->first();
            if (!empty($sql)) {
                $view_sql = 'CREATE OR REPLACE VIEW  ' . $schema->table_schema . '.' . $view . ' AS ' . $sql->pg_get_viewdef;
                DB::connection($destination_connection)->statement($view_sql);
                echo 'View   ' . $view . ' created successfully in new db ' . $destination_connection . ' for schema ' . $schema->table_schema . '<br/>';
            }
        }
    }

    public function resetSequence() {
        //load all schemas
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '3000M');
        $schemas = $this->loadSchema();

        //loop throught schemas, and load all tables, views and functions
        foreach ($schemas as $schema) {
            $sql = "select * from admin.reset_sequence('{$schema->table_schema}')";
            DB::connection($this->destination_connection)->statement($sql);
            echo 'SCHEMA ' . $schema->table_schema . ' sequence reset COMPLETELY <br/><br/><hr/>';
        }
    }

    public function createIndex() {
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '3000M');
        $schemas = $this->loadSchema();

        //loop throught schemas, and load all tables, views and functions
        foreach ($schemas as $schema) {

            $tables = $this->loadTables($schema->table_schema);

            $skip_tables = ['track_invoices', 'track_payments', 'company_files', 'courses', 'other_student', 'track_invoices_fees_installments'];
            foreach ($tables as $table) {
                if (in_array($table, $skip_tables)) {
                    continue;
                }

                $check_table_exists = DB::connection($this->destination_connection)->select("SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='" . $schema->table_schema . "' AND table_name='" . $table . "' and column_default like '%nextval%'");
                $table_info = \collect($check_table_exists)->first();
                if (!empty($table_info)) {
                    $key = '"' . $table_info->column_name . '"';

                    $sql = "ALTER TABLE IF EXISTS {$schema->table_schema}.{$table}
    ADD CONSTRAINT {$table}_id_primary PRIMARY KEY ($key)";

                    DB::connection($this->destination_connection)->statement("ALTER TABLE {$schema->table_schema}.{$table} DROP CONSTRAINT IF EXISTS {$table}_id_primary");
                    DB::connection($this->destination_connection)->statement($sql);
                    echo 'SCHEMA ' . $schema->table_schema . ' index reset COMPLETELY <br/><br/><hr/>';
                }
            }
        }
    }

    public function migration() {
        /**
         * Algorithm to merge into a single database

          1. create schema called ShuleSoft

          2. create materialized view under admin schema or any other schema with all tables

          3. recreate empty database with new tables as default schema

          4. add column if does not exists named schema_name in all tables and index it

          5. add a column if does not exists named uuid in all tables that refer admin schema

          6. add a column if does not exists named uid in all tables that will follow sequences for that particular table

          7. don't drop any sequences from existing tables yet

          8. drop all constrains if exist in the database

          9. copy data from all tables merged in admin schema and insert them in a new schema
          by first testing if the data exists or not

          10. Recreate constrains if does not exists but considering uid, schema name  and not a normal id used before

          11. update all tables with uid for reference checks by
         * creating references that match uid. This will be done automatically if uid is serial

          12. done

         */
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '3000M');
        //adjust to only create schema if does not exists, and only limit to create
        //empty tables and not otherwise
        $schema = DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE table_schema='shulesoft'");
        if (empty($schema)) {
            //recreate an empty tables in shulesoft schema
            DB::statement("select * from public.clone_schemas('zamzam','shulesoft',false,false)");

            //drop all constrains 
            DB::statement("select * from public.drop_constrains('shulesoft')");

//            for ($i = 0; $i < 230; $i + 10) {
//                $p = $i + 10;
//                DB::statement("SELECT * from admin.merge_limit_tables('public',$i,$p)");
//            }
        }
        $master_tables = $this->loadTables('shulesoft');
        foreach ($master_tables as $table) {
            //create a materialized view
            //adjust join_all script to skip skema named called shulesoft
            //once you join all in the admin schema, now add those missing columns uuid, and uid
            //DB::statement('ALTER TABLE IF EXISTS shulesoft.' . $table . ' ADD '
            //         . ' COLUMN IF NOT EXISTS uuid uuid NOT NULL DEFAULT admin.uuid_generate_v4()');
            DB::statement('ALTER TABLE IF EXISTS shulesoft.' . $table . ' ADD '
                    . ' COLUMN IF NOT EXISTS uid serial');
            DB::statement('ALTER TABLE IF EXISTS shulesoft.' . $table . ' ADD '
                    . ' COLUMN IF NOT EXISTS schema_name character varying');

            //DB::statement('ALTER TABLE IF EXISTS shulesoft.' . $table . '   ADD CONSTRAINT  ' . $table . '_uuid_unique UNIQUE (uuid)');

            $sql = "ALTER TABLE IF EXISTS shulesoft.{$table}
    ADD CONSTRAINT {$table}_id_primary PRIMARY KEY (uid)";

            DB::statement("ALTER TABLE IF EXISTS shulesoft.{$table} DROP CONSTRAINT IF EXISTS {$table}_id_primary");
            DB::statement($sql);

            DB::statement('insert into shulesoft.' . $table . ''
                    . ' select * from admin.all_' . $table . ' where uuid not in '
                    . '(select uuid from shulesoft.' . $table . ')');
        }
        //$this->recreateConstrains();
        //once everything is merged, now re-create tables if does not exists
    }

    public function recreateConstrains() {
        echo 'All Data merged successfully';
    }

    public function tables() {
        return view('software.database.tables');
    }

    public function createuuid() {
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '3000M');
        $schemas = $this->loadSchema();
        foreach ($schemas as $schema) {

            $tables = $this->loadTables($schema->table_schema);
            foreach ($tables as $table) {
                DB::statement('ALTER TABLE IF EXISTS ' . $schema->table_schema . '.' . $table . ' ADD '
                        . ' COLUMN IF NOT EXISTS uuid uuid NOT NULL DEFAULT admin.uuid_generate_v4()');
                echo '<br/>uuid created for ' . $schema->table_schema . '.' . $table;
            }
            echo '<br><p>------End For ' . $schema->table_schema . '----</p><br/>';
        }
    }

    public function reversecreateuuid() {

        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '3000M');

        for ($index = 342; $index > 0; $index -= 3) {
            DB::statement('select * from admin.createuuid(' . $index . ',3)');
            echo '<br><p>------uuid created, remais ' . $index . '----</p><br/>';
        }
    }

    public function createIndexSchema($this_schema = null) {
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '3000M');
        $schema = $this_schema != '' ? $this_schema : request('schema');

        //loop throught schemas, and load all tables, views and functions

        $tables = $this->loadTables($schema);

        $skip_tables = ['track_invoices', 'track_payments', 'company_files', 'courses', 'other_student', 'track_invoices_fees_installments'];
        foreach ($tables as $table) {
            if (in_array($table, $skip_tables)) {
                continue;
            }

            $check_table_exists = DB::select("SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='" . $schema . "' AND table_name='" . $table . "' and column_default like '%nextval%'");
            $table_info = \collect($check_table_exists)->first();
            if (!empty($table_info)) {
                $key = '"' . $table_info->column_name . '"';

                $sql = "ALTER TABLE IF EXISTS {$schema}.{$table} ADD CONSTRAINT {$table}_id_primary PRIMARY KEY ($key)";
                DB::statement("ALTER TABLE {$schema}.{$table} DROP CONSTRAINT IF EXISTS {$table}_id_primary");
                DB::statement($sql);
                echo 'SCHEMA ' . $schema . ' for table ' . $table . ' index reset COMPLETELY <br/><br/><hr/>';
            }
        }
    }

}
