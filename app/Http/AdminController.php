<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use//Http//Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;


session_start();

class AdminController extends Controller
{
    //
    public function index(){
        return view('admin_login');
        // echo "Admin controller";
    }

    // public function index1(){
    //     echo "Sajib";
    // }

    public function show_dashboard(){
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){
        //echo "Ok";
        $admin_email = $request->admin_email;
        $admin_password = SHA1($request->admin_password);
        $result = DB::table('tbl_admin')
               ->where('admin_email',$admin_email)
               ->where('admin_password',$admin_password)
               ->first();
            //    echo "<pre>";
            //    print_r($result);
            //    exit();
            if($result){
                Session::put('admin_name',$result->admin_name);
                Session::put('admin_id',$result->admin_id);

                return Redirect::to('/dashboard');
            }else{
                Session::put('message','Email or password Invaild');
                
                return Redirect::to('/admin-login');
            }
    }
}
