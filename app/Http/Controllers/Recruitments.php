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

    public function register() {
         $phone = request('phone'); 
        if (strpos($phone, '0') === 0) {
            $phonenumber = trim(preg_replace('/0/', '+255', $phone, 1));
          }else{
            $phonenumber = trim(request('phone')); 
          }
        //  dd($phonenumber);
        $file = request()->file('documents');
        $file_id = $this->saveFile($file, 'company/contracts', TRUE);
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
        $nda_file_id = $this->saveFile($file, 'company/contracts');
    }

}
