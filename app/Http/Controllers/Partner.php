<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;

class Partner extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index() {
            $this->data['users'] = User::where('status', 1)->where('role_id', '<>', 7)->get();
            return view('users.index', $this->data);
        }
        
    public function addSchool() {
        $id = request()->segment(3);
        $partner = \App\Models\School::find($id);
        $this->data['school'] = $partner;
            if($_POST){

            }
        return view('users.partners.onboarding', $this->data);
    }
}