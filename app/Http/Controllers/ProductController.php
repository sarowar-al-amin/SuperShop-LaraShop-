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

class ProductController extends Controller
{
    //
    public function index(){
        $this->adminAuthCheck();
        return view('admin.add_product');
    }


    public function save_product (Request $request)
    {
        $this->adminAuthCheck();
        $data=array ();
        $data['product_name'] = $request->product_name;
        $data['catagory_id'] = $request->catagory_id;
        $data['manufacture_id'] = $request->manufacture_id;
        $data['product_short_description'] = $request->product_short_description;
        $data['product_long_description'] = $request->product_long_description;
        $data['product_price'] = $request->product_price;
        $data['product_size'] = $request->product_size;
        $data['product_color'] = $request->product_color;
        $data['publication_status'] = $request->publication_status;

        $image=$request->file('product_image');

        if($image){
            $image_name=Str::random(20);
            $ext=strtolower($image->getClientOriginalExtension());
            $img_full_name=$image_name.'.'.$ext;
            $upload_path='image/';
            $img_url=$upload_path.$img_full_name;
            $success=$image->move($upload_path, $img_full_name);
            if($success){
                $data['product_image']=$img_url;
                DB::table('tbl_products')->insert($data);
                Session::put('message', 'Product Successfully Added');
                return Redirect::to ('/add-product');
            }
        }else{
            $data['product_image']='';
            DB::table('tbl_products')->insert($data);
            Session::put('message', 'Product Successfully Added without image');
            return Redirect::to ('/add-product');
        }


    }


    public function all_product(){
        //return view('admin.all_product');  
        $this->adminAuthCheck();
        $all_product_info = DB::table('tbl_products')
            ->join('tbl_catagories','tbl_products.catagory_id','=','tbl_catagories.catagory_id')
            ->join('tbl_manufactures','tbl_products.manufacture_id','=','tbl_manufactures.manufacture_id')
            ->select('tbl_products.*','tbl_catagories.catagory_name','tbl_manufactures.manufacture_name')
            ->get();
            
        $manage_product= view('admin.all_product')
            ->with('all_product_info',$all_product_info);
        return view('admin_layout')
            ->with('admin.all_product',$manage_product);
    }

    public function deactive_product($product_id){
        //echo $product_id;
        $this->adminAuthCheck();
        DB::table('tbl_products')
           ->where('product_id',$product_id)
           ->update(['publication_status' => 0]);
           Session::put('message','Product deactivated successfully!');   
        return Redirect::to('/all-product');
    }


    public function active_product($product_id){
        //echo $product_id;
        $this->adminAuthCheck();
        DB::table('tbl_products')
           ->where('product_id',$product_id)
           ->update(['publication_status' => 1 ]);
           Session::put('message','Product activated successfully!');   
        return Redirect::to('/all-product');
    }


    public function delete_product($product_id){
        //echo $manufacture_id;
        $this->adminAuthCheck();
        DB::table('tbl_products')
           ->where('product_id',$product_id)
           ->delete();
        Session::get('message','Product deleted successfully!');
        return Redirect::to('/all-product');
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
