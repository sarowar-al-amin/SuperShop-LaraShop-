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



    public function show_dashboard(){

        $this->adminAuthCheck();
        return view('admin.dashboard');
    }

    public function logout(){
        // Session::put('admin_name',null);
        // Session::put('admin_id',null);
        Session::flush();
        return Redirect::to('/admin-login');
    }

    public function adminAuthCheck(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return;
        }else{
            return Redirect::to('/admin-login')->send();
        }
    }
}
