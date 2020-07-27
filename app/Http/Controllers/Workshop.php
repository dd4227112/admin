<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
        }
        return redirect('/workshop')->with('success', request('title') . ' updated successfully');
    }

}
