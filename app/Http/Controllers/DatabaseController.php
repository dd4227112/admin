<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page=null,$sub=null)
    {
        $data= ($page ==null || in_array($page, array('login')))?'':$this->$page($sub);
        $page= $page !='compareColumn' ? 'comparetable':'comparecolumn';
       return view('database.'.strtolower($page),compact('data','page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function compareTable($schema)
    {
      return $this->compareSchemaTables($schema);
    }


public function compareColumn($pg=null){
return DB::select("SELECT distinct table_schema, count(table_name) FROM INFORMATION_SCHEMA.TABLES group by table_schema");
}

/**
* @var Default Schema which is stable
*/
    protected static $master_schema='testing';

/**
* @var $schema : Schema name which we want to know its tables
* @return List of tables in that schema
*/
    public function loadTables($schema) {
    $tables = DB::select("SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema= '". $schema ."'  AND table_type='BASE TABLE'");
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
    public function loadTableColumns($schema,$table) {
    $tables = DB::select("SELECT table_name, column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='". $schema ."' AND table_name='".$table."'");
    $column_names = array();
    foreach ($tables as $table) {
        array_push($column_names, $table->column_name);
    }
    return $column_names;
    }

    public function compareSchemaTables($slave_schema = null) {
    $master_tables = $this->loadTables(self::$master_schema);
    $db_file =DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES");
    ///$db_file = file_get_contents('app/config/development/db.txt');
    $schemas = $slave_schema == null ? $db_file : array($slave_schema);
        $stable= '<h4>Tables/Views that are missing are as follows</h4>';
    foreach ($schemas as $schema_name) {
        $schema=is_object($schema_name) ? $schema_name->table_schema :$schema_name;
        $slave_tables = $this->loadTables($schema);
        $diff = array_diff($master_tables, $slave_tables);
    
      $stable.= ' <b>' . $schema . '</b><p>Missing Tables: ' . implode(',', $diff) . ' </p>';

foreach ($diff as $table) {
     $stable.= "<a href='".url('database/syncTable?table='.$table.'&slave='.$schema)."'>Sync <b>".$table."</b> Tables</a><br/>";
       
}
       $stable.= '<hr/>';
    }
    return $stable;
    }
/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function compareTableColumn($slave_schema=null) {
    $master_tables = $this->loadTables(self::$master_schema);
    $db_file = DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES");
    $schemas = $slave_schema == null ?  $db_file : array($slave_schema);
 $stable='';

    foreach ($schemas as $schema_name) {
 //load all column in this main table
        $schema=is_object($schema_name) ? $schema_name->table_schema :$schema_name;
        foreach ($master_tables as $table) {
            # code...
            $master_columns=$this->loadTableColumns(self::$master_schema,$table);
            $slave_columns=$this->loadTableColumns($schema,$table);
            //missing columns
             $missing_columns = array_diff($master_columns, $slave_columns);
if(!empty($missing_columns)){ 
              $stable.="Schema Name: ".$schema;
              $stable.= "<br/>Table Name:".$table;
              $stable.= "<br/>Missing columns: ".implode(',', $missing_columns).'<br/>';
             foreach ($missing_columns as $column) {
      $stable.= "<a href='".url('database/syncColumn?table='.$table.'&slave='.$schema.'&column='.$column)."'>Sync <b>".$column."</b> column</a><br/>";      
}
              $stable.= "<br/><hr/>";
            }
        }  
    }
    return  $stable;
    }

    public function syncTable(){
        $master_table_name= request('table');
        $slave_schema=request('slave');
        $sql=DB::select("select show_create_table('".$master_table_name."','".$slave_schema."') as result");
        $sq=array_shift($sql);
         DB::statement($sq->result);
         return redirect('database/compareTable');
    }

   public function syncColumn($master_table=null,$schema=null,$column_missing=null){
//select from information schema where column name is that which is missing
    //selectfrom information schema table and know data type, default value for that column name
    //complete sql below by adding correct datatype at the end and default column
    $master_table= request('table');
    $schema=request('slave');
    $column_missing=request('column');

   $table_sql="SELECT column_default,data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='".self::$master_schema."' AND table_name='".$master_table."' AND column_name='".$column_missing."' ";

   $check_table_exists=DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema='".$schema."' AND table_name='".$master_table."' ");
   if(!empty($check_table_exists)){
    $tb= DB::select($table_sql);
    $table=array_shift($tb);

    $sql='ALTER TABLE '.$schema.'.'.$master_table.' ADD COLUMN  "'.$column_missing.'"  '.$table->data_type;
    DB::statement($sql);
    
    if($table->column_default !=''){
      $alter_sql='ALTER TABLE '.$schema.'.'.$master_table.' ALTER COLUMN  "'.$column_missing.'" SET DEFAULT'.$table->column_default;
      DB::statement($alter_sql);
    }elseif ($table->is_nullable=='NO') {
     $alter_sql='ALTER TABLE '.$schema.'.'.$master_table.' ALTER COLUMN  "'.$column_missing.'" SET NOT NULL';
     DB::statement($alter_sql);
    }
}else{
    return "This table does not exists in ".$schema.' schema. Run "background/compareTableColumn"' ;
}
return redirect('database/compareTableColumn/'.$schema);
   }

   public function addIndex(){
    $sql="SELECT c.oid, c.relname, a.attname, a.attnum, i.indisprimary, i.indisunique
FROM pg_index AS i, pg_class AS c, pg_attribute AS a
WHERE i.indexrelid = c.oid AND i.indexrelid = a.attrelid AND i.indrelid = 'YOURSCHEMA.YOURTABLE'::regclass
ORDER BY c.oid, a.attnum";
   }

public function upgrade(){
    if(request('sql') !=''){
        $script=$this->createUpgradeScript();
    }else{
        $script='';
    }
    return view('database.upgrade',compact('script'));
}
    public function createUpgradeScript($slave_schema=null) {
    $db_file = request('sql');
    $skip=request('skip');
    $skip_schema= preg_match('/,/', $skip)? explode(',', $skip): array($skip);
    $db_schema =DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES");;
    $schemas = $slave_schema == null ?  $db_schema : array($slave_schema);
    $q='';
     foreach ($schemas as $schema_name) {
        $schema=is_object($schema_name) ? $schema_name->table_schema :$schema_name;
         if(in_array($schema,$skip_schema)) continue;
            $sql1 = str_replace('testing', $schema, $db_file);
            $sql = preg_replace("/\--[^)]+\--/", "", $sql1);
            $queries = explode(';', $sql);
            foreach ($queries as $query) {
                # code...
                $q.= $query.'; ';
            }
    }
    return $q;
    }
}
