<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\CartDetail;
Use App\ProductDetail;
class CartController extends Controller
{
    function cart($id)
    {
        try{

            $quantity = CartDetail::productidQuantity($id);
            echo $quantity;
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
        }
        if(count($quantity)==0)
        {
            try{
                CartDetail::insertData( ['customercart_phone'=>session('active_user'),'product_id'=>$id,'quantity'=>1]);
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
        }
        else{
            try{
                CartDetail::updateCartitem($id,$quantity[0]->quantity+1); 
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
        }
        return redirect("product/$id")->with('success',"Added to cart!!");
    }
    function cartItems()
    {
        try{
            $products= CartDetail::cartInnerjoinProductDetails();
            return view('cart',['product_cart'=>$products]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in showing cart items";
        }
    }

    function checkOutcart(){
        $product_cart= CartDetail::cartInnerjoinProductDetails();
        $price=0;
        foreach($product_cart as $product)
        {
            $price+=$product->price-($product->price*$product->discount/100);
        }
        return view('checkoutcart',['products'=>$product_cart,'totalprice'=>$price]);
     }
     function removeFromcart($id)
     {
         CartDetail::removeProduct($id);
         return redirect('cart');
     }
}
