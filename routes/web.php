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
use Illuminate\Support\Facades\Auth;


Route::get('/','FlipZoneController@showContent');
Route::get('register', function () {
    return view('register');
});
Route::get('login',[ 'as' => 'login',function(){
    return view('login');
}]);
Route::get('logout','UserController@logout');

Route::group( ['middleware'=>'protectedPages'],function()
{
    
    Route::get('merchant_dashboard','DashboardProductController@dashboard');
    Route::get('add_product_details',function()
    {
        return view('add_product_detail');
    });
    Route::post('add_product','DashboardProductController@addProduct');
    Route::post('order_product/{id}','OrderController@orderCheck');
    Route::get('order_successful',function()
    {
        return view('order_successful');
    });
    Route::get('order_history','OrderController@orderHistory');
    Route::get('checkout/{Id}','OrderController@checkOut');
    Route::get('cart/{Id}','CartController@cart');
    Route::get('cart','CartController@cartItems');
    Route::get('checkoutcart','CartController@checkOutcart');
    Route::post('order_products','OrderController@ordersCheckout');
    Route::get('productdetails','DashboardProductController@productDetails');
    Route::get('order_receive','OrderController@orderReceived');
    Route::post('edit_product_details/{id}','DashboardProductController@editProductDetail');
    Route::get('editproduct/{id}','DashboardProductController@editProductView');
    Route::get('deleteproduct/{id}','DashboardProductController@deleteProduct');
    Route::get('resolved/{id}','DashboardProductController@resolved');
    Route::get('cancel_order/{id}','OrderController@cancelOrder');
    Route::get('removefromcart/{id}','CartController@removeFromcart');
    Route::get('edit_profile','UserController@editProfile');
    Route::get('change_password','UserController@changePassword');
    Route::post('update_password','UserController@updatePassword');
    Route::post('update_profile','UserController@updateProfile');

});
Route::post('register','UserController@userRegistration');
Route::post('login','UserController@userLogin');
Route::get('/products','ProductController@showProducts');
Route::get('contact_us',function()
{
    return view('contact_us');
});
Route::get('about_us',function()
{
    return view('about_us');
});
Route::get('discount','ProductController@discountProduct');
Route::get('filter_apply_price','ProductController@filterApplyPrice');
Route::get('sortBylowtohigh','ProductController@lowTohigh');
Route::get('sortByhightolow','ProductController@highTolow');
Route::post('searchproduct','ProductController@searchProduct');
Route::get('present','DashboardProductController@presentUser');
Route::get('product/{Id}','ProductController@product');
Route::post('contact_us','FlipZoneController@contactUs');
Route::get('error',function()
{
    return view('error');
});
