<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\CartDetail;
Use App\ProductDetail;
class CartController extends Controller
{
    //
    function cart($id)
    {
        $cart_table=new CartDetail;   
        $quantity_cart = CartDetail::where('product_id',$id)->get();
        //$quantity_product = ProductDetail::where('Id',$id)->get();
        echo count($quantity_cart);
        if(count($quantity_cart)==0)
        {
            $cart_table->customercart_phone=session('active_user');
            $cart_table->product_id=$id;
            $cart_table->quantity=1;
            $cart_table->save();
        }
        else{
            $quantity_cart[0]->quantity+=1;
            $q=$quantity_cart[0]->quantity;
             CartDetail::where('product_id',$id)->update(['quantity'=>$q]);
             
        }
        //$q=$quantity_product[0]->quantity;
        return redirect("product/$id")->with('success',"Added to cart!!");
    }

    function cartItems()
    {
        $product_cart= CartDetail::join('Product_Details','Product_Details.Id','=','Cart_Details.product_id')
        ->select('Product_Details.product_name','Product_Details.company_name','Product_Details.offer','Product_Details.image_path','Cart_Details.quantity',
        'Product_Details.price','Product_Details.discount')
        ->get();
        //echo $product_cart;
        //$product_cart = CartDetail::where('customercart_phone',session('active_user'))->get();
        return view('cart',['product_cart'=>$product_cart]);
    }
}
