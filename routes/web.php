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
Route::get('/','FlipZoneController@showContent');
Route::get('register', function () {
    return view('register');
});
Route::get('login',function(){
    return view('login');
});
/*Route::get('merchant_register',function()
{
    return view('merchant_registration');
});
Route::get('merchant_login',function(){
    return view('merchant_login');
});
*/
Route::get('merchant_dashboard',function()
{
    return view('merchant_dashboard');
});
Route::get('add_product_details',function()
{
    return view('add_product_detail');
});

Route::post('register','UserController@userRegistration');
Route::post('login','UserController@userLogin');
//Route::post('login_merchant','MerchantController@merchantLogin');
//Route::post('register_merchant','MerchantController@merchantRegistration');
Route::post('add_product','AddProductController@addProduct');
Route::get('products','ProductController@showProducts');
Route::get('contact_us',function()
{
    return view('contact_us');
});
Route::get('about_us',function()
{
    return view('about_us');
});
Route::post('filter_apply_price','ProductController@filterApplyPrice');
Route::post('sortBylowtohigh','ProductController@lowtohigh');
Route::post('sortByhightolow','ProductController@hightolow');
//Route::post('sortByrating','ProductController@rating');
Route::get('present','AddProductController@presentUser');