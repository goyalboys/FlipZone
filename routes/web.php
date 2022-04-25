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
use App\mail\SendEmailMailable;

// Route::get('sendmail', function(){
//     Mail::to('vineetgoyal789@gmail.com')->send(new SendEmailMailable());
//     return "Email is send Properly";
// });

Route::get('register','FlipZoneController@register');
Route::get('login','FlipZoneController@login');
Route::get('contact_us','FlipZoneController@contactPage');
Route::get('about_us','FlipZoneController@aboutPage');
Route::get('error','FlipZoneController@errorPage');
Route::get('/','FlipZoneController@showContent');
Route::post('raise_ticket','FlipZoneController@ticket');

Route::get('logout','UserController@logout');
Route::post('register','UserController@userRegistration');
Route::post('login','UserController@userLogin');

Route::get('/products','ProductController@showProducts');
Route::get('discount','ProductController@discountProduct');
Route::get('filter_apply_price','ProductController@filterApplyPrice');
Route::get('sortBylowtohigh','ProductController@lowTohigh');
Route::get('sortByhightolow','ProductController@highTolow');
Route::post('searchproduct','ProductController@searchProduct');
Route::get('product/{Id}','ProductController@product');

Route::group( ['middleware'=>'protectedPages'],function()
{
    
    Route::get('add_product','DashboardController@productPage');
    Route::post('add_product','DashboardController@addProduct');
    Route::get('productdetails','DashboardController@productDetails');
    Route::post('edit_product_details/{id}','DashboardController@editProductDetail');
    Route::get('editproduct/{id}','DashboardController@editProduct');
    Route::get('deleteproduct/{id}','DashboardController@deleteProduct');
    Route::get('resolved/{id}','DashboardController@resolved');
    Route::get('merchant_dashboard','DashboardController@dashboard');

    Route::get('cancel_order/{id}','OrderController@cancelOrder');
    Route::get('order_receive','OrderController@orderReceived');
    Route::post('order_product/{id}','OrderController@orderCheck');
    Route::get('order_history','OrderController@orderHistory');
    Route::get('checkout/{Id}','OrderController@checkOut');
    Route::post('order_products','OrderController@ordersCheckout');
    Route::get('order_successful', 'OrderController@status');

    Route::get('removefromcart/{id}','CartController@removeFromcart');
    Route::get('cart/{Id}','CartController@cart');
    Route::get('cart','CartController@cartItems');
    Route::get('checkoutcart','CartController@checkOutcart');

    Route::get('edit_profile','UserController@editProfile');
    Route::get('change_password','UserController@changePassword');
    Route::post('update_password','UserController@updatePassword');
    Route::post('update_profile','UserController@updateProfile');

});