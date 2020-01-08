<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use//Http//Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class ManufactureController extends Controller
{
    //
    public function index(){
        // echo "Quite boring life!!" ;
        return view('admin.add_manufacture');

    } 


    public function save_manufacture(Request $request){
        $data = array();
        $data['manufacture_id'] = $request->manufacture_id;
        $data['manufacture_name'] = $request->manufacture_name;
        $data['manufacture_description'] = $request->manufacture_description;
        $data['publication_status'] = $request->publication_status;

        // echo "<pre>";
        //   print_r($data);
        // echo "</pre>";
        DB::table('tbl_manufactures')->insert($data);
        Session::put('message','Manufacture added successfully!');

        return Redirect::to('/add-manufacture');
    }

    public function all_manufacture(){
        //return view('admin.all_manufacture');  
        $all_manufacture_info = DB::table('tbl_manufactures')->get();
        $manage_manufacture = view('admin.all_manufacture')
            ->with('all_manufacture_info',$all_manufacture_info);
        return view('admin_layout')
            ->with('admin.all_manufacture',$manage_manufacture);
    }

    public function delete_manufacture($manufacture_id){
        //echo $manufacture_id;
        DB::table('tbl_manufactures')
           ->where('manufacture_id',$manufacture_id)
           ->delete();
        Session::get('message','Manufacture deleted successfully!');
        return Redirect::to('/all-manufacture');
    }

    public function deactive_manufacture($manufacture_id){
        //echo $manufacture_id;
        DB::table('tbl_manufactures')
           ->where('manufacture_id',$manufacture_id)
           ->update(['publication_status' => 0]);
           Session::put('message','Manufacture deactivated successfully!');   
        return Redirect::to('/all-manufacture');
    }


    public function active_manufacture($manufacture_id){
        //echo $manufacture_id;
        DB::table('tbl_manufactures')
           ->where('manufacture_id',$manufacture_id)
           ->update(['publication_status' => 1 ]);
           Session::put('message','Manufacture activated successfully!');   
        return Redirect::to('/all-manufacture');
    }
    
    public function edit_manufacture($manufacture_id){
        //echo $manufacture_id;
        //return view('admin.edit_manufacture');
        $manufacture_info = DB::table('tbl_manufactures')
           ->where('manufacture_id', $manufacture_id)
           ->first();
        
        $manufacture_info = view('admin.edit_manufacture')
           ->with('manufacture_info',$manufacture_info);

        return view('admin_layout')
            ->with('admin.edit_manufacture',$manufacture_info);
    }


    public function update_manufacture(Request $request, $manufacture_id){
        $data = array();
        $data['manufacture_name'] = $request->manufacture_name;
        $data['manufacture_description'] = $request->manufacture_description;

        // print_r($data);
        // echo $manufacture_id;
        DB::table('tbl_manufactures')
           ->where('manufacture_id',$manufacture_id)
           ->update($data);

        Session::get('message','Manufacture updated successfully!'); 

        return Redirect::to('/all-manufacture');

    }

}
