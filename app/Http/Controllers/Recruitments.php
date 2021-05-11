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
         $phonenumber = preg_replace('/0/', '+255', $phone, 1);
        }else{
         $phonenumber = request('phone'); 
        }
        $file = request()->file('documents');
      //   $file_id = $this->saveFile($file, 'company/contracts');
         $file_id = 1;
        
       $recruiment = \App\Models\Recruiment::create(array_merge(request()->except('phone'), ['phone' => $phonenumber,'company_file_id' =>$file_id ]));
        // dd($recruiment);
         if(isset($recruiment)){
            return redirect('Recruitments/quiz/'. $recruiment->id);
          //  return redirect(url('recruiments/quiz/' . $recruiment->id));
         }
    }


    public function quiz(){
        $this->data['id'] = $id = request()->segment(3);
        $this->data['title'] = 'Shulesoft Application Questions';
        return view('applicant_questions',$this->data);

           $applicant = \App\Models\Recruiment::findOrFail($id);
           dd($applicant);

             // if( request('email')){
        //     $message = '<h4>Dear ' . request('name') .  '</h4>'
        //     .'<h4>I trust this email finds you well.</h4>'
        //     .'<p>Please find below the details for the Shulesoft Webinar session to be held on '.$workshop->event_date.'.</p>'
        //     .'<p>Link: https://meet.google.com/ney-osuq-bsq </p>'
        //     .'<br/>'
        //     .'<p>Join through Google Meeting, You have an option to use Smartphone or Computer, if you’re going to use a smartphone, you have to download an application click that link to do so. Remember to join the session 5 minutes before the specified time in order to test your device</p>'
        //     .'<p><br>Looking forward to hearing your contribution in the discussion.</p>'
        //     .'<br>'
        //     .'<p>Thanks and regards,</p>'
        //     .'<p><b>Shulesoft Team</b></p>'
        //     .'<p> Call: +255 655 406 004 </p>';
        //     $this->send_email(request('email'), 'ShuleSoft Recruiment Application', $message);

        //     $message1 = 'Dear ' . request('name') .  '.'
        //     .chr(10).'Thanks for registering for the Shulesoft Webinar session to be held on '.$workshop->event_date.'.'
        //     .chr(10).'Topic: '. $workshop->title . '.'
        //     .chr(10).'Time: '. $workshop->start_time .' - ' .$workshop->end_time. ''
        //     .chr(10).'Link: https://meet.google.com/ney-osuq-bsq .'
        //     .chr(10)
        //     .'Remember to join the session 5 minutes before the specified time in order to test your device.'
        //     .chr(10).' Looking forward to hearing your contribution in the discussion.'
        //     .chr(10).'Thanks and regards,'
        //     .chr(10).'Shulesoft Team' 
        //     .chr(10).' Call: +255 655 406 004 ';
        //     $sql = "insert into public.sms (body,user_id, type,phone_number) values ('$message1', 1, '0', '$phonenumber')";
        //     DB::statement($sql);

        //     echo "<script>
        //         alert('Conglatulations for registering!!! We glad to have you.');
        //         window.location.href='https://www.shulesoft.com/';
        //     </script>";
        //     }
    }

   

}
