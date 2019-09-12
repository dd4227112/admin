<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $data;

    public function createBarGraph() {
        $sql = 'select count(created_at::date), "user"  as dataname,created_at::date as timeline from all_log where "user" is not null group by "user",created_at::date order by created_at::date desc limit 10 ';
        $this->data['results'] = DB::select($sql);
        // return view('graph.bargraph', $this->data);
    }

    public function ajaxTable($table, $columns, $custom_sql = null) {
        ## Read value
        if (isset($_POST) && request()->ajax() == true) {
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value
## Search 
            $searchQuery = " ";
            if ($searchValue != '') {
                $searchQuery = " and ( ";
                $list = '';
                foreach ($columns as $column) {
                    $list .= 'lower(' . $column . "::text) like '%" . strtolower($searchValue) . "%' or ";
                }
                $searchQuery = $searchQuery . rtrim($list, 'or ') . ' )';
            }

## Total number of records without filtering
            // $sel = DB::select("select count(*) as allcount from employee");
## Total number of record with filtering
## Fetch records
            $columnName = strlen($columnName) < 1 ? '1' : $columnName;
            if (strlen($custom_sql) < 2) {
                $sel = DB::select("select * from " . $table . " WHERE true " . $searchQuery);

                $empQuery = "select * from " . $table . " WHERE true " . $searchQuery . " order by \"" . $columnName . "\" " . $columnSortOrder . " offset  " . $row . " limit " . $rowperpage;
            } else {
                $empQuery = $custom_sql . " " . $searchQuery . " order by \"" . $columnName . "\" " . $columnSortOrder . " offset  " . $row . " limit " . $rowperpage;
                $sel = DB::select($custom_sql);
            }
            $empRecords = DB::select($empQuery);


## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => count($sel),
                "iTotalDisplayRecords" => count($sel),
                "aaData" => $empRecords
            );

            return json_encode($response);
        }
    }

}
