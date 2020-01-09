<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use//Http//Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class HomeController extends Controller
{
    public function index(){
       //return view('pages.home_content') ;

       $all_published_product = DB::table('tbl_products')
       ->join('tbl_catagories','tbl_products.catagory_id','=','tbl_catagories.catagory_id')
       ->join('tbl_manufactures','tbl_products.manufacture_id','=','tbl_manufactures.manufacture_id')
       ->select('tbl_products.*','tbl_catagories.catagory_name','tbl_manufactures.manufacture_name')
       ->where('tbl_products.publication_status',1)
       ->limit(9)
       ->get();


       $manage_published_product= view('pages.home_content')
        ->with('all_published_product',$all_published_product);

        return view('layout')
        ->with('pages.home_content',$manage_published_product);


    }
}
