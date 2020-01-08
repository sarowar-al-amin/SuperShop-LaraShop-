<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use//Http//Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class ProductController extends Controller
{
    //
    public function index(){
        return view('admin.add_product');
    }


    public function save_product (Request $request)
    {
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
            $image_name=str_random(20);
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

        }
        $data['product_image']='';
            DB::table('tbl_products')->insert($data);
            Session::put('message', 'Product Successfully Added without image');
            return Redirect::to ('/add-product');



    }

}
