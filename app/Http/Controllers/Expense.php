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

   
    

}