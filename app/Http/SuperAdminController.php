<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use//Http//Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class SuperAdminController extends Controller
{
    //
    public function logout(){
        // Session::put('admin_name',null);
        // Session::put('admin_id',null);
        Session::flush();
        return Redirect::to('/admin-login');
    }
}
