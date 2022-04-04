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
use Illuminate\Support\Facades\session;

Route::get('/','FlipZoneController@showContent');
Route::get('register', function () {
    return view('register');
});
Route::get('login',[ 'as' => 'login',function(){
    return view('login');
}]);
Route::get('logout',function(){
    session::flush();
    return redirect('login');
});

Route::group( ['middleware'=>'protectedPages'],function(){
    Route::get('merchant_dashboard',function()
    {
        return view('merchant_dashboard');
    });
    Route::get('add_product_details',function()
    {
        return view('add_product_detail');
    });
    Route::post('add_product','DashboardProductController@addProduct');
    Route::post('{Id}/order_product','OrderController@orderCheck');
    Route::get('order_successful',function()
    {
        return view('order_successful');
    });
    Route::get('order_history','OrderController@orderHistory');
    Route::get('checkout/{Id}','OrderController@checkOut');
    Route::get('cart/{Id}','CartController@cart');
    Route::get('cart','CartController@cartItems');
    Route::get('checkoutcart','OrderController@checkOutcart');
    Route::post('order_products','OrderController@ordersCheckout');
    Route::get('productdetails','DashboardProductController@productDetails');
    Route::get('order_receive','DashboardProductController@orderReceived');
    Route::post('edit_product_details/{id}','DashboardProductController@editProductDetail');
    Route::get('editproduct/{id}','DashboardProductController@editProductView');
    Route::get('deleteproduct/{id}','DashboardProductController@deleteProduct');
});

Route::post('register','UserController@userRegistration');
Route::post('login','UserController@userLogin');
//Route::post('login_merchant','MerchantController@merchantLogin');
//Route::post('register_merchant','MerchantController@merchantRegistration');

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
Route::post('sortBylowtohigh','ProductController@lowTohigh');
Route::post('sortByhightolow','ProductController@highTolow');

Route::post('searchproduct','ProductController@searchProduct');
//Route::post('sortByrating','ProductController@rating');
Route::get('present','DashboardProductController@presentUser');

Route::get('product/{Id}','ProductController@product');


/*Route::get('merchant_register',function()
{
    return view('merchant_registration');
});
Route::get('merchant_login',function(){
    return view('merchant_login');
});
*/