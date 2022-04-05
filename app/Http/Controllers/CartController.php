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
        try{
            $cartTable=new CartDetail;
            $quantityCart = CartDetail::where('product_id',$id)->get();
        }
        catch(Exception $e)
        {
            echo "cart detail error in product id";
            dd($e->getMessage());

        }
        if(count($quantityCart)==0)
        {
            try{
                $cartTable->customercart_phone=session('active_user');
                $cartTable->product_id=$id;
                $cartTable->quantity=1;
                $cartTable->save();
            }
            catch(Exception $e)
            {
                echo "error in adding product in cart";
                dd($e->getMessage());
                
            }
        }
        else{
            try{
                $quantityCart[0]->quantity+=1;
                $q=$quantityCart[0]->quantity;
                CartDetail::where('product_id',$id)->update(['quantity'=>$q]); 
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
                echo "error in updating quantity";
            }
        }
        try{
            return redirect("product/$id")->with('success',"Added to cart!!");
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in redirection to product id";
        }
    }
    function cartItems()
    {
        try{
            $productCart= CartDetail::join('Product_Details','Product_Details.Id','=','Cart_Details.product_id')
            ->select('Product_Details.product_name','Product_Details.company_name','Product_Details.offer','Product_Details.image_path','Cart_Details.quantity',
            'Product_Details.price','Product_Details.discount')->get();
            return view('cart',['product_cart'=>$productCart]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in showing cart items";
        }
    }
}
