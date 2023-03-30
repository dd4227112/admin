<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Jobs\PushSMS;

class Recruitments extends Controller {
    
    public function index() {
        $this->data['title'] = 'Shulesoft Application Form';
        return view('registerrecruiment',$this->data);
    }
    public function report(){
       $data = DB::connection('mysql')->select('SELECT a.id, a.name, a.price, b.name as brand_name from sma_products a  left join sma_brands b on a.brand = b.id order by id');
       $print_out ="<table style='border:1px solid black; width:100%; ' cellspacing='0'> ";
       $print_out.= "<tr><th style ='border:1px solid black; width:5%;text-align:center;'>id</th style ='border:1px solid black;'><th style ='border:1px solid black;'>Product name</th><th style ='border:1px solid black;'>Brand</th><th style ='border:1px solid black;'>Price</th></tr>";
       foreach ($data as $value) {
        $print_out.= "<tr><td style ='width:5%;text-align:center;border:1px solid black'>".$value->id."</td><td style ='border:1px solid black;'>".$value->name."</td><td style ='border:1px solid black;'>".$value->brand_name."</td><td style ='border:1px solid black; text-align:right;'>".number_format($value->price, 2)."</td'></tr>";
       } 
       $print_out.="</table>";
 
       echo $print_out;
    }
    public function register() {
         $phone = request('phone'); 
        if (strpos($phone, '0') === 0) {
            $phonenumber = trim(preg_replace('/0/', '+255', $phone, 1));
          }else{
            $phonenumber = trim(request('phone')); 
          }
        $file = request()->file('documents');
         if(filesize($file) > 2015110 ) {
            return redirect()->back()->with('error', 'File must have less than 2MBs');
          }
        $file_id = $this->saveFile($file, TRUE);
        // $file_id = 1;
        
       $recruiment = \App\Models\Recruiment::create(array_merge(request()->except('phone'), ['phone' => $phonenumber,'company_file_id' =>$file_id ]));
            if(request('email')){
            $message = '<h4>Dear ' . request('fullname') .  '</h4>'
            .'<h4>I trust this email finds you well.</h4>'
            .'<br/>'
            .'<p><br>Your application has been submitted successful.</p>'
            .'<br>'
            .'<p>Thanks and regards,</p>'
            .'<p><b>Shulesoft Team</b></p>'
            .'<p> Call: +255 655 406 004 </p>';
            $this->send_email(request('email'), 'ShuleSoft Recruiment Application', $message);
            $this->send_whatsapp_sms($user->phone, $sms);

         }
         return redirect('Recruitments/quiz/'. $recruiment->id);
   }



    public function quiz(){
        $this->data['id'] = $id = request()->segment(3);
        $option = request()->segment(4);
       
         if($option == 'submit'){
            $applicant = \App\Models\Recruiment::findOrFail($id);
            $where = ["recruiment_id" => $applicant->id];
            $score =  \App\Models\RecruimentAnswers::selectRaw('SUM(answer) as total,recruiment_id')->where($where)->groupBy('recruiment_id')->first()->total;
            $total_value = 1000;
            $percent = $score / $total_value * 100;
            \App\Models\Recruiment::where('id',$applicant->id)->update(["score" => $score]);
         }
         $this->data['title'] = 'Shulesoft Application Questions';
         return view('applicant_questions',$this->data);
    }

   
    public function quizAnswers(){
        if($_POST){
            $data = ["answer" => request('answer'),"question_id" => request('question_id'),"recruiment_id" => request('recruiment_id')];
            $arr = ["question_id" => request('question_id'),"recruiment_id" => request('recruiment_id')];
            $check =  \App\Models\RecruimentAnswers::where($arr)->first();
           !empty($check) ? \App\Models\RecruimentAnswers::where($arr)->update(["answer" => request('answer')]) : \App\Models\RecruimentAnswers::create($data);    
        }
        echo 'Answered';
    }


    public function nda(){
        $this->data['title'] = 'Shulesoft NDA Form';
        return view('nda_form',$this->data);
    }

    public function uploadnda(){
        $file = request()->file('nda_form');
        dd($file);

        if(filesize($file) > 2015110 ) {
            return redirect()->back()->with('error', 'File must have less than 2MBs');
         }
        $nda_file_id = $this->saveFile($file, TRUE);
    }

}
