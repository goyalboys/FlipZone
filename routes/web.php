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


Route::get('contact_us','FlipZoneController@contactPage');
Route::get('about_us','FlipZoneController@aboutPage');
Route::get('error','FlipZoneController@errorPage');
Route::get('/','FlipZoneController@showContent');
Route::post('raise_ticket','FlipZoneController@ticket');

Route::get('register','UserController@register');
Route::post('register','UserController@userRegistration');
Route::get('login','UserController@login')->name('login');
Route::post('login','UserController@userLogin');
Route::get('logout','UserController@logout');


Route::get('/products','ProductController@showProducts');
Route::get('discount','ProductController@discountProduct');
Route::get('filter_apply_price','ProductController@filterApplyPrice');
Route::get('sortBylowtohigh','ProductController@lowTohigh');
Route::get('sortByhightolow','ProductController@highTolow');
Route::get('searchproduct','ProductController@searchProduct');
Route::get('product/{Id}','ProductController@product');

Route::group( ['middleware'=>'protectedPages'],function()
{
    Route::get('dashboard','DashboardController@dashboard');
    Route::get('add_product','DashboardController@productPage');
    Route::post('add_product','DashboardController@addProduct');
    Route::get('merchant_products','DashboardController@productDetails');
    Route::get('edit_product/{id}','DashboardController@editProduct');
    Route::put('edit_product/{id}','DashboardController@editProductDetails');
    Route::delete('delete_product/{id}','DashboardController@deleteProduct')->name('delete_product');
    Route::delete('delete_ticket/{id}','DashboardController@resolved')->name('delete_ticket');
    Route::get('order_receive','DashboardController@orderReceived');

    Route::get('edit_profile','UserController@editProfile');
    Route::get('change_password','UserController@changePassword');
    Route::put('update_password','UserController@updatePassword');
    Route::put('update_profile','UserController@updateProfile');

    Route::get('cart','CartController@cartItems');//show elements to cart
    Route::put('cart/{Id}','CartController@cartAddItem')->name('addProductToCart');//item added to cart
    Route::delete('removefromcart/{id}','CartController@removeFromcart')->name('removeFromCart');//particular cart item will be deleted
    Route::get('checkoutcart','CartController@checkOutcart');//all product in cart will be checkout for order

    Route::get('order/{Id}','OrderController@checkOut');
    Route::post('order/{Id}','OrderController@orderProduct');
    Route::post('order_products','OrderController@orderProducts');//it will order all cart items
    Route::get('order_successful', 'OrderController@status');
    Route::get('order_history','OrderController@orderHistory');
    Route::delete('cancel_order/{id}','OrderController@cancelOrder')->name('cancelOrder');
});