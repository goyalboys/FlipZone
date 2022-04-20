<?php

namespace App\Http\Controllers;
use App\ProductDetail;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
Use App\CartDetail;
use Exception;
use App\Http\Requests\CheckOutFormValidation;

class OrderController extends Controller
{
    function checkOut($Id)
    {
        try
        {
            $product=ProductDetail::productIddetail($Id);
            return view('checkout',['product'=>$product]);
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
    }
    function orderCheck(CheckOutFormValidation $request,$Id)
    {

        $request->validate();
        $product=ProductDetail::productIddetail($Id);  
        $price=$product[0]->price-($product[0]->price*$product[0]->discount/100);

        OrderDetail::addOrder([ 'name' =>$request->name,'address' =>$request->address,'pincode' =>$request->pincode,
        'city' =>$request->city,'state' =>$request->state,'price' =>$price,'payment_mode' =>$request->cash_payment,
        'customer_phone' =>session('active_user'),'phone_no' =>$request->phone_number,'product_id'=>$Id,'added_on'=>Carbon::now()]);

        ProductDetail::updateProduct($Id,['quantity'=>$product[0]->quantity-1]);
        return redirect('order_successful')->with('success',"Done!!");
    }
    function orderHistory()
    {
        try
        {
            $orders=OrderDetail::ordersInnerJoinproductdetails(session('active_user'));
            return view('order_history',['orders'=>$orders]);
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
    }
    function ordersCheckout(CheckOutFormValidation $request)
    {
        $request->validate();
        try{
            $productsIdQuantity= CartDetail::productidQuantityId(session('active_user'));
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
        foreach($productsIdQuantity as $productIdQuantity )
        {
            $productId=$productIdQuantity->product_id;
            $quantity=$productIdQuantity->quantity;
            while($quantity)
            {
                $quantity--;
                $product=ProductDetail::productIddetail($productId,1);
                $price =$product[0]->price-($product[0]->price*$product[0]->discount/100);
                $orderTable=new OrderDetail;
                if(($product[0]->quantity-1)>=0)
                {
                    OrderDetail::addOrder([ 'name' =>$request->name,'address' =>$request->address,'pincode' =>$request->pincode,
                    'city' =>$request->city,'state' =>$request->state,'price' =>$price,'payment_mode' =>$request->cash_payment,
                    'customer_phone' =>session('active_user'),'phone_no' =>$request->phone_number,'product_id'=>$productId,'added_on'=>Carbon::now()]);
                    ProductDetail::updateProduct($productId,['quantity'=>$product[0]->quantity-1]);
                }
            }
        }
        CartDetail::deleteCartItems(session('active_user'));
        return redirect('order_successful')->with('success',"Done!!");
    }
     function orderReceived()
    {
        try
        {
            $orders=OrderDetail::ordersInnerJoinproductdetails(session('active_user'));
            return view('order_receive',['products'=>$orders]);
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
    }
    function cancelOrder($id)
     {
         try
         {
            $orderProductid=OrderDetail::productId($id);
            $productIdQuantity= ProductDetail::productQuantity($orderProductid);
            $quantity=$productIdQuantity[0]->quantity;
            OrderDetail::deleteOrder($id);
            ProductDetail::updateProduct($orderProductid,['quantity'=>$quantity+1]);
         }
         catch(Exception $e)
         {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
         }
        return redirect('order_history');
     }
}
