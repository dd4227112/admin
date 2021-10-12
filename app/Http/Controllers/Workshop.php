<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Jobs\PushSMS;

class Workshop extends Controller {

    public function __construct() {
        
    }

    public function index() {
        $this->data['event'] = \App\Models\Events::first();
        return view('workshop', $this->data);
    }

    public function register() {
        $this->data['event'] = \App\Models\Events::latest()->first();
        return view('registerworkshop', $this->data);
    }

    public function addregister() {
        $phonenumber = validate_phone_number(request('phone'), request('country_code'));
        $workshop = \App\Models\Events::where('id', request('event_id'))->first();
        $obj = [
            'phone' => $phonenumber, 'name' => request('name'),
            'position' => request('position'), 'school_id' => request('school_id'),
            'event_id' => request('event_id'),
            'source' => request('source')];
        $check_attendee = \App\Models\EventAttendee::where('phone', $phonenumber)->where('event_id', request('event_id'))->first();

        if (empty($check_attendee)) {
            $event = \App\Models\EventAttendee::create($obj);
        } else {
            $event = $check_attendee;
        }
        if (!empty($event->id)) {
            $message1 = 'Dear ' . request('name') . '.'
                    . chr(10) . 'Thanks for registering for the Shulesoft Webinar session to be held on ' . $workshop->event_date . '.'
                    . chr(10) . 'Topic: ' . $workshop->title . '.'
                    . chr(10) . 'Time: ' . $workshop->start_time . ' - ' . $workshop->end_time . ''
                    . chr(10) . chr(10) . 'Link: ' . $workshop->meeting_link . ' .'
                    . chr(10)
                    . 'Remember to join the session 5 minutes before the specified time in order to test your device.'
                    . chr(10) . 'Looking forward to hearing your contribution in the discussion.'
                    . chr(10) . 'Thanks and regards,'
                    . chr(10) . 'Shulesoft Team'
                    . chr(10) . ' Call: +255 655 406 004 ';
            DB::table('public.sms')->insert([
                'body'=>$message1,
                'user_id'=>1,
                'type'=>0,
                'priority' => 1,
                'sent_from' => 'whatsapp',
                'phone_number'=> str_replace('2550', '+255', $phonenumber)
            ]);
            $chatId = $phonenumber . '@c.us';
            $this->sendMessage($chatId, $message1);
            $this->sendEmail($phonenumber, $workshop);
            return view('market.summary');
//            $link = 'https://www.shulesoft.com';
//            echo "<h3>Conglatulations for registering!!! We glad to have you.'); </h3>";
//            echo '<a href="#" onclick="window.location.href=\'' . $link . '\'>Close</a>';
        }
    }

    public function sendEmail($phone, $workshop) {
        $check = DB::table('admin.all_users')->where('phone', 'ilike', $phone)->first();
        if (!empty($check) && filter_var($check->email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Dear ' . request('name') . '' . chr(10)
                    . 'Please find below the details for the Shulesoft Webinar session to be held on ' . $workshop->event_date . '.' . chr(10)
                    . 'Topic: ' . $workshop->title . '' . chr(10)
                    . 'Time: ' . $workshop->start_time . ' - ' . $workshop->end_time . ' ' . chr(10)
                    . 'Link: ' . $workshop->meeting_link . ' ' . chr(10)
                    . '<br/>'
                    . 'You have an option to use Smartphone or Computer, if you’re going to use a smartphone, you have to download an application click that link to do so. Remember to join the session 5 minutes before the specified time in order to test your device'
                    . '<br>Looking forward to hearing your contribution in the discussion.'
                    . '<br>'
                    . 'Thanks and regards,'
                    . 'Shulesoft Team'
                    . 'Call: +255 655 406 004 ';
            $this->send_email($check->email, 'ShuleSoft Webinar on ' . $workshop->title, $message);
        }
    }

    public function profile() {
        $id = request()->segment(2);
        $this->data['id'] = $id;
        $this->data['profile'] = \App\Models\User::where(DB::raw("md5(email)"), $this->data['id'])->first();
        return view('user_profile', $this->data);
    }

    public function deleteUser() {
        $id = request()->segment(3);
        \App\Models\EventAttendee::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'success');
    }
    
    public function syncMissingPayments() {
        $background = new \App\Http\Controllers\Background();
        $url = 'http://75.119.140.177:8081/api/init';
        $fields = json_decode(urldecode(request('data')));
        $curl = $background->curlServer($fields, $url, 'row');
        return $curl;
        // return redirect()->back()->with('success',$curl);
    }
}
