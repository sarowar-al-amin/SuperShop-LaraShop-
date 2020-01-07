<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use//Http//Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class CatagoryController extends Controller
{
    //
    public function index(){
       // echo "Added a new catagory";
       return view('admin.add_category');
    }

    public function all_catagory(){
        //return view('admin.all_category');  
        $all_category_info = DB::table('tbl_catagories')->get();
        $manage_category = view('admin.all_category')
            ->with('all_category_info',$all_category_info);
        return view('admin_layout')
            ->with('admin.all_category',$manage_category);
    }

    public function save_category(Request $request){
        $data = array();
        $data['catagory_id'] = $request->catagory_id;
        $data['catagory_name'] = $request->catagory_name;
        $data['catagory_description'] = $request->catagory_description;
        $data['publication_status'] = $request->publication_status;

        // echo "<pre>";
        //   print_r($data);
        // echo "</pre>";
        DB::table('tbl_catagories')->insert($data);
        Session::put('message','Category added successfully!');

        return Redirect::to('/add-category');
    }
}
