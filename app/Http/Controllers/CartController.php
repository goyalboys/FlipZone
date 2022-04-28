<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\CartDetail;
Use App\ProductDetail;
use Exception;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    function cartItems()
    {
        try
        {
            $products= CartDetail::fetchProductFromCart( [ 'customercart_phone' => session( 'active_user' )] );
        }
        catch(Exception $e)
        {
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return view('cart.cart',['product_cart'=>$products]);
    }

    function cartAddItem($id)
    {
        try
        {
            $quantity = CartDetail::fetchProductQuantityFromId($id);
            if(empty($quantity))
            {
                $array = [ "known_error" => "invalid page" ];
                return redirect('error')->withInput()->withErrors($array);
            }
        }
        catch(Exception $e)
        {
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        if(count($quantity)==0)
        {
            try
            {
                DB::beginTransaction();
                CartDetail::insertData( [ 'customercart_phone' => session('active_user'), 'product_id' => $id,'quantity' => 1] );
                DB::Commit();
            }
            catch(Exception $e)
            {
                DB::rollback();
                $array = [ "error" => $e->getMessage() ];
                return redirect('error')->withInput()->withErrors($array);
            }
        }
        else
        {
            try
            {
                DB::beginTransaction();
                CartDetail::updateCartItem( $id, $quantity[0]->quantity+1 );
                DB::Commit();
            } 
            catch(Exception $e)
            {
                DB::rollback();
                $array = [ "error" => $e->getMessage() ];
                return redirect('error')->withInput()->withErrors($array);
            }
        }
        return redirect("product/$id")->with('success',"Added to cart!!");
    }
    

    function checkOutcart()
    {
        try
        {
            $product_cart= CartDetail::fetchProductFromCart( [ 'customercart_phone' => session('active_user') ] );
        }
        catch(Exception $e)
        {
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        $price=0;
        foreach($product_cart as $product)
        {
            $price+=$product->price-($product->price*$product->discount/100);
        }
        return view('cart.checkoutcart',['products' => $product_cart,'totalprice'=>$price]);
     }

     function removeFromcart($id)
     {
        try
        {
            if( empty( CartDetail::checkProductId($id) ))
            {
                $array = [ "error" => "Do not exit in cart" ];
                return redirect('known_error')->withInput()->withErrors($array);
            }
            DB::beginTransaction();
            CartDetail::removeCartItem($id);
            DB::Commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('cart');
     }
}
