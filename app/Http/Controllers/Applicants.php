<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;

class Applicants extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function evaluations() {
        $this->data['applicants'] =  \App\Models\Recruiment::orderBy('created_at', 'desc')->get();
        return view('applicants.index', $this->data);
      }


      public function show() {
        $id = request()->segment(3);
        if($id > 0) {
          $this->data['applicant'] =  \App\Models\Recruiment::findOrFail($id);
        }
        return view('applicants.show', $this->data);
      }


      public function rejectapplicant(){
        $id = request()->segment(3);
        $applicant =  \App\Models\Recruiment::where('id',$id)->first();
          \App\Models\Recruiment::where('id',$id)->update(['status'=>0]);
        if($applicant->email){
          $message = '<h4>Dear ' . $applicant->fullname .  '</h4>'
          .'<h4>I trust this email finds you well.</h4>'
          .'<br/>'
          .'<p><br>Your application has been rejected .</p>'
          .'<br>'
          .'<p>Thanks and regards,</p>'
          .'<p><b>Shulesoft Team</b></p>'
          .'<p> Call: +255 655 406 004 </p>';
          $this->send_email($applicant->email, 'ShuleSoft Recruiment Application', $message);
        }
        return redirect('Applicants/evaluations');
      }


      public function acceptapplicant(){
        $id = request()->segment(3);
        \App\Models\Recruiment::where('id',$id)->update(['status'=>1]);
        $applicant =  \App\Models\Recruiment::where('id',$id)->first();
        
        if($applicant->email){
        $message = '<h4>Dear ' . $applicant->fullname .  '</h4>'
        .'<h4>I trust this email finds you well.</h4>'
        .'<p>Kindly open this link below</p>'
        .'<br/>'
        .'<p>Link: https://admin.shulesoft.com/nda_form </p>'
        .'<br/>'
        .'<p>Download a NDA file from link,Fill it and submit if on the provided form.Remember to fill correctly the form before submit</p>'
        .'<br>'
        .'<p>Thanks and regards,</p>'
        .'<p><b>Shulesoft Team</b></p>'
        .'<p> Call: +255 655 406 004 </p>';
        $this->send_email($applicant->email, 'ShuleSoft Job application ', $message);
        //dd($id);
      }
      return redirect('Applicants/evaluations');
    
}




}




