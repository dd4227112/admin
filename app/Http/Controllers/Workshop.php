<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Jobs\PushSMS;
class Workshop extends Controller {
    
    public function __construct(){
        
    }
    
    
    public function index() {
        $this->data['event'] = \App\Models\Events::first();
        return view('workshop', $this->data);
    }

    public function register() {
    $this->data['event'] = \App\Models\Events::first();
    return view('registerworkshop', $this->data);
    }
 
    public function addregister() {
        $string = '_maua';
        $phone = request('phone'); 
        if (strpos($phone, '0') === 0) {
        $phonenumber = preg_replace('/0/', '+255', $phone, 1);
        }else{
            $phonenumber = request('phone'); 
        }
        $event = \App\Models\EventAttendee::create(array_merge(request()->except('phone'), ['phone' => $phonenumber]));
        if(count($event->id) > 0 && request('email')){
            
$message = '<h4>Dear ' . request('name') . 'Conglatulations!  </h4><br/>'
.'<h>I trust this email finds you well.</p>'
. '<p></p>'
.'<p>Please find below the details for the Shulesoft Webinar session to be held on '.request('event_date').'.</p>'
.'<h4>Workshop details</h4>'
.'<p>Topic: '. request('title') . '</p>'
.'<p>Time: '. request('start_time') .' - ' .request('end_time'). ' <br/>'
.'<p>Join Google Meeting <p>'
.'<p>Link: https://meet.google.com/ney-osuq-bsq </p>'
.'<p>You have an option to use Smartphone or Computer, if you’re going to use a smartphone, you have to download an application click that link to do so. Remember to join the session 5 minutes before the specified time in order to test your device</p>'
.'<p><br>We glad to have you. Looking forward to hearing your contribution in the discussion.</p>'
.'<br>'
.'<br>'
.'<p>Thanks and regards,</p>'
.'<p><b>Shulesoft Team</b></p>'
.'<p> Call: +255 655 406 004 </p>';
$this->send_email(request('email'), 'ShuleSoft Webinar on '.request('title'), $message);
echo "<script>
alert('Conglatulations for registering!!! We glad to have you.');
window.location.href='https://www.shulesoft.com/';
</script>";
}
    }

}
