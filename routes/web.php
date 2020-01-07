<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//frontend routes code 
Route::get('/','HomeController@index');

// Route::get('/', function () {
//     return view('layout');
// });




//backend routes code
//Route::get('/backend','AdminController@index');
// I don't know why this above line of code is not working.
Route::get('/admin-login','AdminController@index');
Route::get('/dashboard','AdminController@show_dashboard');
Route::post('/admin-dashboard','AdminController@dashboard');
Route::get('/logout','SuperAdminController@logout');


//category routes
Route::get('/add-category','CatagoryController@index');
Route::get('/all-category','CatagoryController@all_catagory');
Route::post('/save-category','CatagoryController@save_category');