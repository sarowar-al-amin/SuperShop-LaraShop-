<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
// use//Http//Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

session_start();


//$this->adminAuthCheck();

class SliderController extends Controller
{
   public function index(){
       $this->adminAuthCheck();
       return view('admin.add_slider');
   }

   public function save_slider (Request $request)
   {
       $this->adminAuthCheck();
       $data=array ();
       $data['publication_status'] = $request->publication_status;
       $image=$request->file('slider_image');
       if($image){
           $image_name=Str::random(20);
           $ext=strtolower($image->getClientOriginalExtension());
           $img_full_name=$image_name.'.'.$ext;
           $upload_path='slider/';
           $img_url=$upload_path.$img_full_name;
           $success=$image->move($upload_path, $img_full_name);
           if($success){
               $data['slider_image']=$img_url;
               DB::table('tbl_sliders')->insert($data);
               Session::put('message', 'SliderSuccessfully Added');
               return Redirect::to ('/add-slider');
           }
       }else{
           $data['product_image']='';
           DB::table('tbl_sliders')->insert($data);
           Session::put('message', 'Slider Successfully Added without image');
           return Redirect::to ('/add-slider');
       }
    }


   public function all_slider(){

        $this->adminAuthCheck();
        //return view('admin.all_slider');  
        $all_slider_info = DB::table('tbl_sliders')->get();
        $manage_slider = view('admin.all_slider')
            ->with('all_slider_info',$all_slider_info);
        return view('admin_layout')
            ->with('admin.all_slider',$manage_slider);
    }
    public function deactive_slider($slider_id){
        //echo $slider_id;
        $this->adminAuthCheck();
        DB::table('tbl_sliders')
           ->where('slider_id',$slider_id)
           ->update(['publication_status' => 0]);
           Session::put('message','slider deactivated successfully!');   
        return Redirect::to('/all-slider');
    }


    public function active_slider($slider_id){
        //echo $slider_id;
        $this->adminAuthCheck();
        DB::table('tbl_sliders')
           ->where('slider_id',$slider_id)
           ->update(['publication_status' => 1 ]);
           Session::put('message','slider activated successfully!');   
        return Redirect::to('/all-slider');
    }

    public function delete_slider($slider_id){
        //echo $slider_id;
        $this->adminAuthCheck();
        DB::table('tbl_sliders')
           ->where('slider_id',$slider_id)
           ->delete();
        Session::get('message','Slider deleted successfully!');
        return Redirect::to('/all-slider');
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
