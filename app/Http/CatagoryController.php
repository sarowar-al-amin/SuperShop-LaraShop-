<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use//Http//Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

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

    public function deactive_category($catagory_id){
        //echo $catagory_id;
        DB::table('tbl_catagories')
           ->where('catagory_id',$catagory_id)
           ->update(['publication_status' => 0]);
           Session::put('message','Category deactivated successfully!');   
        return Redirect::to('/all-category');
    }


    public function active_category($catagory_id){
        //echo $catagory_id;
        DB::table('tbl_catagories')
           ->where('catagory_id',$catagory_id)
           ->update(['publication_status' => 1 ]);
           Session::put('message','Category activated successfully!');   
        return Redirect::to('/all-category');
    }
    
    public function edit_category($catagory_id){
        //echo $catagory_id;
        //return view('admin.edit_category');
        $category_info = DB::table('tbl_catagories')
           ->where('catagory_id', $catagory_id)
           ->first();
        
        $category_info = view('admin.edit_category')
           ->with('category_info',$category_info);

        return view('admin_layout')
            ->with('admin.edit_category',$category_info);
    }


    public function update_category(Request $request, $catagory_id){
        $data = array();
        $data['catagory_name'] = $request->catagory_name;
        $data['catagory_description'] = $request->catagory_description;

        // print_r($data);
        // echo $catagory_id;
        DB::table('tbl_catagories')
           ->where('catagory_id',$catagory_id)
           ->update($data);

        Session::get('message','Category updated successfully!'); 

        return Redirect::to('/all-category');

    }

    public function delete_category($catagory_id){
        //echo $catagory_id;
        DB::table('tbl_catagories')
           ->where('catagory_id',$catagory_id)
           ->delete();
        Session::get('message','Category deleted successfully!');
        return Redirect::to('/all-category');
    }


}
