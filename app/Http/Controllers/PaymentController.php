<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests()
    {
        $this->data['requests']= \App\Request::latest()->paginate();
        return view('payment.api_requests', $this->data);
    }
}
