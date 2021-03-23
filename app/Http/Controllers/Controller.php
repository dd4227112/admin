<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Charts\SimpleChart;
use DB;
use Auth;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $data;

    
    /**
     *
     * @var Graph title 
     */
    public $graph_title = '';

    /**
     *
     * @var x axis 
     */
    public $x_axis = '';

    /**
     *
     * @var y axis 
     */
    public $y_axis = '';

    public function createBarGraph() {
        $sql = 'select count(created_at::date), "user"  as dataname,created_at::date as timeline from all_log where "user" is not null group by "user",created_at::date order by created_at::date desc limit 10 ';
        $this->data['results'] = DB::select($sql);
        // return view('graph.bargraph', $this->data);
    }

    public function ajaxTable($table, $columns, $custom_sql = null, $order_name = null, $count = null) {
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
            $total_records = 0;
            if (strlen($custom_sql) < 2) {
                // strlen($searchQuery); exit;
                $sel = \collect(DB::select("select count(*) as count from " . $table . " WHERE true " . $searchQuery))->first();
                $total_records = $sel->count;

                $empQuery = "select * from " . $table . " WHERE true " . $searchQuery . " order by \"" . $columnName . "\" " . $columnSortOrder . " offset  " . $row . " limit " . $rowperpage;
            } else {
                $empQuery = $custom_sql . " " . $searchQuery . " order by \"" . $columnName . "\" " . $columnSortOrder . " offset  " . $row . " limit " . $rowperpage;

                $total_records = $count == null ? count(DB::select($custom_sql)) : $count;
            }
            $empRecords = DB::select($empQuery);


## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $total_records,
                "iTotalDisplayRecords" => $total_records,
                "aaData" => $empRecords
            );

            return json_encode($response);
        }
    }

    public function send_email($email, $subject, $message) {

       // if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $obj = array('body' => $message, 'subject' => $subject, 'email' => $email);
            DB::table('public.email')->insert($obj);
       // }

        return $this;
    }

    public function send_sms($phone_number, $message, $priority = 0) {
        if ((strlen($phone_number) > 6 && strlen($phone_number) < 20) && $message != '') {
            $sms_keys_id = DB::table('public.sms_keys')->first()->id;
            DB::table('public.sms')->insert(array('phone_number' => $phone_number, 'body' => $message, 'type' => $priority, 'priority' => $priority, 'sms_keys_id' => $sms_keys_id));
        }
        return $this;
    }

    public function saveFile($file, $subfolder = null, $local = null) {

        $path = \Storage::disk('s3')->put($subfolder, $file);
        $url = \Storage::disk('s3')->url($path);

        if (strlen($url) > 10) {
            return DB::table('company_files')->insertGetId([
                        'name' => $file->getClientOriginalName(),
                        'extension' => $file->getClientOriginalExtension(),
                        'user_id' => Auth::user()->id,
                        'size' => $file->getSize(),
                        'caption' => $file->getRealPath(),
                        'path' => $url
            ]);
        } else {
            return false;
        }
    }

    public function curlPrivate($fields, $url = null) {
        // Open connection
        $url = 'http://51.77.212.234:8081/api/payment';
        $ch = curl_init();
// Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'application/x-www-form-urlencoded'
        ));

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    /**
     * 
     * @param type $sql
     * @param type $firstpart
     * @param type $table
     * @param type $chart_type
     * @param type $custom
     * @return type
     */
    public function createChartBySql($sql, $firstpart, $table, $chart_type, $custom = false, $call_back_sql = false) {
        $data = DB::select($sql);
        return $this->createGraph($data, $firstpart, $table, $chart_type, $custom, $call_back_sql);
    }

    /**
     * 
     * @param type $table
     * @param type $base_column
     * @param type $join_table
     * @param type $join_table_array
     * @param type $chart_type
     * @param type $custom
     * @param type $as_alias
     * @return type
     */
    public function createChart($table, $base_column, $join_table = false, $join_table_array = false, $chart_type = 'bar', $custom = false, $as_alias = false) {

        $data = $join_table == false ? DB::table($table)
                        ->select(DB::raw('count(*)'), DB::raw($base_column))
                        ->groupBy(DB::raw($as_alias == FALSE ? $base_column : $as_alias))->get() :
                DB::table($table)
                        ->join($join_table, array_keys($join_table_array)[0] . '.' . array_values($join_table_array)[0], array_keys($join_table_array)[1] . '.' . array_values($join_table_array)[1])
                        ->select(DB::raw('count(*)'), DB::raw($base_column))
                        ->groupBy(DB::raw($as_alias == FALSE ? $base_column : $as_alias))->get();
        $column = preg_replace('/^([^::]*).*$/', '$1', $as_alias == FALSE ? $base_column : $as_alias);
        list($firstpart) = explode(',', $column);
        return $this->createGraph($data, $firstpart, $table, $chart_type, $custom);
    }

    /**
     * 
     * @param type $data
     * @param type $chart_type
     * @param type $base_column
     * @return type
     */
    private function createCustomChart($data, $chart_type, $base_column) {
        $insight = $this;
        return view('insight.highcharts', compact('data', 'chart_type', 'base_column', 'insight'));
    }

    /**
     * 
     * @param type $data
     * @param type $firstpart
     * @param type $table
     * @param type $chart_type
     * @param type $custom
     * @param type $call_back_sql
     * @return type
     */
    private function createGraph($data, $firstpart, $table, $chart_type, $custom = false, $call_back_sql = false) {
        $k = [];
        $l = [];
        foreach ($data as $value) {
            array_push($k, $value->{$firstpart});
            array_push($l, (int) $value->count);
        }
        $chart = new SimpleChart;
        $chart->labels($k);
        $chart->dataset($this->x_axis == '' ? $table : $this->x_axis, $chart_type, $l);

        if ($call_back_sql != false) {
            foreach ($call_back_sql as $key => $sql) {
                $call = $this->createCallBack(DB::select($sql), $firstpart);
                $chart->labels($call[0]);
                $chart->dataset($key, $chart_type, $call[1]);
            }
        }
        $title = $this->graph_title == '' ?
                ucwords('Relationship Between ' . $table . ' and ' . str_replace('_', ' ', $firstpart)) : $this->graph_title;
        $chart->title($title);
        $this->data['chart'] = $chart;
        return $custom == true ? $this->createCustomChart($data, $chart_type, $firstpart) : view('analyse.charts.chart', $this->data);
    }

    /**
     * 
     * @param type $data
     * @param type $firstpart
     * @return type
     */
    private function createCallBack($data, $firstpart) {
        $k = [];
        $l = [];
        foreach ($data as $value) {
            array_push($k, $value->{$firstpart});
            array_push($l, (int) $value->count);
        }
        return [$k, $l];
    }


    public function uploadExcel($sheet_name = null) {
        //        $file = request()->file('file');
        //        $data = $this->fileload($file);
        //        dd($data);
        //        exit;
        //        $this->load->library('PHPExcel');
        try {
            // it will be your file name that you are posting with a form or c
            //an pass static name $_FILES["file"]["name"]
            $folder = "storage/uploads/media/";
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
            //is_dir($folder) ? '' : mkdir($folder, 0777,True);
            $file = request()->file('file');
            //$name=  str_replace('.'.$file->guessClientExtension(), '', $file->getClientOriginalName());
            $name = time() . rand(4343, 3243434) . '.' . $file->guessClientExtension();
            $move = $file->move($folder, $name);
            $path = $folder . $name;
            if (!$move) {
                die('upload Error');
            } else {
                $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            }
        } catch (Exception $e) {
            $this->resp->success = FALSE;
            $this->resp->msg = 'Error Uploading file';
            echo json_encode($this->resp);
        }
        $sheets = $objPHPExcel->getSheetNames();
        if ($sheet_name == null) {
            return $this->getDataBySheet($objPHPExcel, 0);
        } else {
            $data = [];
            foreach ($sheets as $key => $value) {
                $data[$value] = [];
            }
            foreach ($sheets as $key => $value) {
                $excel_data = $this->getDataBySheet($objPHPExcel, $key);
                count($excel_data) > 0 ? array_push($data[$value], $excel_data) : '';
            }
            return $data;
        }
        unlink($path);
    }

}
