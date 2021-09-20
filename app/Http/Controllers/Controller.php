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
    var $APIurl = 'https://eu4.chat-api.com/instance210904/';
    var $token = 'h67ddfj89j8pm4o8';
    public $bot;
    public $main_menu = '';

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


  
 //Altenative function to store files on localstorage
    public function saveFile($file, $subfolder = null, $local = null) {
        if ($local == TRUE) { 
            $url = $this->uploadFileLocal($file);
            $file_id = DB::table('company_files')->insertGetId([
                'extension' => $file->getClientOriginalExtension(),
                'name' => $file->getClientOriginalName(),
                'user_id' => \Auth::user()->id,
                'size' => 0,
                'caption' => $file->getRealPath(),
                'path' => $url
            ]);
            return $file_id;
        } 
    }

    public function uploadFileLocal($file) {
       //Move Uploaded File
        $destinationPath = 'storage/uploads/images';
        !is_dir($destinationPath) ? mkdir($destinationPath) : '';
        $filename = rand(145, 87998) . time() . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $filename);
        return url($destinationPath . '/' . $filename);
    }

    public function curlPrivate($fields, $url = null) {
        // Open connection
        $url = 'http://75.119.140.177:8081/api/payment';
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

    //sends a file. it is called when the bot gets the command "file"
    //@param $chatId [string] [required] - the ID of chat where we send a message
    //@param $format [string] [required] - file format, from the params in the message body (text[1], etc)
    public function file($chatId, $format, $filename, $caption = null) {
        $availableFiles = array(
            'doc' => 'document.doc',
            'gif' => 'gifka.gif',
            'jpg' => 'jpgfile.jpg',
            'png' => 'pngfile.png',
            'pdf' => 'presentation.pdf',
            'mp4' => 'video.mp4',
            'mp3' => 'mp3file.mp3'
        );

        if (isset($availableFiles[$format])) {
            $data = array(
                'chatId' => $chatId,
                'body' => $filename,
                'filename' => $availableFiles[$format],
                'caption' => $caption
            );
            $this->sendRequest('sendFile', $data);
        }
        if (strtolower($format) == 'ogg') {
            $data = array(
                'audio' => $filename,
                'chatId' => $chatId
            );
            $this->sendRequest('sendAudio', $data);
        }
    }

    //sends a voice message. it is called when the bot gets the command "ptt"
    //@param $chatId [string] [required] - the ID of chat where we send a message
    public function ptt($chatId) {
        $data = array(
            'audio' => 'https://shulesoft.com/PHP/ptt.ogg',
            'chatId' => $chatId
        );
        $this->sendRequest('sendAudio', $data);
    }

    //creates a group. it is called when the bot gets the command "group"
    //@param chatId [string] [required] - the ID of chat where we send a message
    //@param author [string] [required] - "author" property of the message
    public function group($author) {
        $phone = str_replace('@c.us', '', $author);
        $data = array(
            'groupName' => 'Group with the bot PHP',
            'phones' => array($phone),
            'messageText' => 'It is your group. Enjoy'
        );
        $this->sendRequest('group', $data);
    }

    public function sendMessage($chatId, $text) {
        $data = array('chatId' => $chatId, 'body' => $text);
        $this->sendRequest('message', $data);
    }

    public function sendRequest($method, $data) {
        if (strlen($this->APIurl) > 5 && strlen($this->token) > 3) {

            $url = $this->APIurl . $method . '?token=' . $this->token;
            if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                $url = $this->token . $method . '?token=' . $this->APIurl;
            }

            if (is_array($data)) {
                $data = json_encode($data);
            }
            $options = stream_context_create(['http' => [
                    'method' => 'POST',
                    'header' => 'Content-type: application/json',
                    'content' => $data]]);
            $response = file_get_contents($url, false, $options);
            // $response = $this->curlServer($body, $url);
            $requests = array('chat_id' => '43434', 'text' => $response, 'parse_mode' => '', 'source' => 'user');
            // file_put_contents('requests.log', $response . PHP_EOL, FILE_APPEND);
        } else {
            echo 'Wrong url supplied in whatsapp api';
        }
    }


      public function send_whatsapp_sms($phone, $message) {
        if ((strlen($phone) > 6 && strlen($phone) < 20) && $message != '') {
            $message = str_replace("'", "", $message);
            DB::statement("insert into admin.whatsapp_messages(message, status, phone) select '{$message}','0',admin.whatsapp_phone('{$phone}') from admin.users where status=1 and phone ='{$phone}'");
        }
        return $this;
    }

}


