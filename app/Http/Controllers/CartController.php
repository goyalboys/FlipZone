<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\CartDetail;
Use App\ProductDetail;
use Exception;
class CartController extends Controller
{
    function cart($id)
    {
        try
        {
            $quantity = CartDetail::productidQuantity($id);
            //echo $quantity;
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
            
        }
        if(count($quantity)==0)
        {
            try
            {
                CartDetail::insertData( ['customercart_phone'=>session('active_user'),'product_id'=>$id,'quantity'=>1]);
            }
            catch(Exception $e)
            {
                $array = [
                    "error"=>$e->getMessage()
                ];
                return redirect('error')->withInput()->withErrors($array);
            }
        }
        else
        {
            try
            {
                CartDetail::updateCartitem($id,$quantity[0]->quantity+1); 
            }
            catch(Exception $e)
            {
                $array = [
                    "error"=>$e->getMessage()
                ];
                return redirect('error')->withInput()->withErrors($array);
            }
        }
        return redirect("product/$id")->with('success',"Added to cart!!");
    }
    function cartItems()
    {
        try
        {
            $products= CartDetail::cartInnerjoinProductDetails();
            return view('cart',['product_cart'=>$products]);
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
    }

    function checkOutcart()
    {
        try
        {
            $product_cart= CartDetail::cartInnerjoinProductDetails();
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
        $price=0;
        foreach($product_cart as $product)
        {
            $price+=$product->price-($product->price*$product->discount/100);
        }
        return view('checkoutcart',['products'=>$product_cart,'totalprice'=>$price]);
     }
     function removeFromcart($id)
     {
        try
        {
            CartDetail::removeProduct($id);
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('cart');
     }
}
