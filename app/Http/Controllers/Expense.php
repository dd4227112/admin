<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;


class Expense extends Controller {

    function __construct() {
        $this->middleware('auth');
    }

 
    public function index() {
        $this->data['id'] = $id = request()->segment(3);
        if ((int) $id) {
            if ($_POST) {
                $from_date = request("from_date");
                $to_date = request("to_date");
            } else {
                $from_date = date('Y-01-01');
                $to_date = date('Y-m-d');
            }
            $this->data['from_date'] = $from_date;
            $this->data['to_date'] = $to_date;
          
            $this->data['expenses'] = $this->getCategories_by_date($id, $from_date, $to_date); 
            return view('account.transaction.expense', $this->data);
        } else{
            return view('account.transaction.expense', $this->data);
        }
   
    }


    public function getCategories_by_date($id, $from_date, $to_date) {
        switch ($id) {
            case 1:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->where('financial_category_id', 4)->orderBy('created_at', 'desc')->get();
                break;
            case 2:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->where('financial_category_id', 6)->orderBy('created_at', 'desc')->get();
                break;
            case 3:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->where('financial_category_id', 7)->orderBy('created_at', 'desc')->get();
                break;
            case 4:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->whereIn('financial_category_id', [2, 3])->orderBy('created_at', 'desc')->get();
    
                break;
            case 5:
                $result = \App\Models\ReferExpense::whereBetween('created_at', [$from_date, $to_date])->where('financial_category_id', 5)->orderBy('created_at', 'desc')->get();
                break;
            default:
                $result = array();
                break;
        }
        return $result;
    }



    public function getCategories($id) {
        switch ($id) {
            case 1:
                $result = \App\Models\ReferExpense::where('financial_category_id', 4)->get();
                break;
            case 2:
                $result = \App\Models\ReferExpense::where('financial_category_id', 6)->get();
                break;
            case 3:
                $result = \App\Models\ReferExpense::where('financial_category_id', 7)->get();
                break;
            case 4:
                $result = \App\Models\ReferExpense::whereIn('financial_category_id', [2, 3])->get();
                break;
            case 5:
                $result = \App\Models\ReferExpense::where('financial_category_id', 5)->get();
                break;
            case 6:
                $result = \App\Models\ReferExpense::where('financial_category_id', 6)->get();
                break;
            default:
                $result = array();
                break;
        }
        return $result;
    }



    public function uploadExpenses() 
    { 
        Excel::import(new ImportExpense, request()->file('expense_file'));
        return redirect('account/transaction/4')->with('success', 'All Expense Uploaded Successfully!');
    }


    public function updateCompleteItems(){
        $checks = DB::select('select * from admin.train_items where status=1');
        foreach($checks as $check){
            if (preg_match('/exam/i', strtolower($check->content))) {

                    $schemas = DB::select('select * from admin.all_setting');
                    foreach($schemas as $schema){
                    $classes = DB::table($schema->schema_name . '.classes')->count();
                    $exams = DB::table($schema->schema_name . '.exam_report')->whereYear('created_at', date('Y'))->count();
                    $client = $this->client($schema->schema_name);
                    if ($exams >= $classes) {
                          $this->updateStatus($check->id, $client->id);
                       }
                    }

              } else if (preg_match('/invoice/i', strtolower($check->content))) {
                //receive at least 10 payments
                    $schemas = DB::select('select * from admin.all_setting');
                    foreach($schemas as $schema){
                    $payments = DB::table($schema->schema_name . '.payments')->whereYear('created_at', date('Y'))->count();
                     $client = $this->client($schema->schema_name);
                    if ($payments >= 10) {
                          $this->updateStatus($check->id, $client->id);
                        }
                    }

              }

         }
     }

     private function client($schema_name){
        return strlen($schema_name) > 2 ? DB::table('admin.clients')->where('username', $schema_name)->first() : '';
     }

     private function updateStatus($item_id,$client_id){
           $training = \App\Models\TrainItemAllocation::where('train_item_id', $item_id)->where('client_id', $client_id)->first();
            if(!empty($training)){
              \App\Models\TrainItemAllocation::where('train_item_id',$item_id)->where('client_id', $client_id)->update(['status' => '1']);
            }
     }
   
    

}