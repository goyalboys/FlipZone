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
use Illuminate\Support\Facades\DB;
use NewException;

class OrderController extends Controller
{
    function checkOut($Id)
    {
        try
        {
            $product=ProductDetail::productIddetail($Id);
            if(empty($product))
            {
                throw New Exception('Product not found');
            }
        }
        catch(Exception $e)
        {
            $array = [ "error"=>$e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return view('checkout',['product'=>$product]);
    }
    function orderProduct(CheckOutFormValidation $request,$Id)
    {
        try{
            DB::beginTransaction();
            $request->validate();
            $product=ProductDetail::productIddetail($Id);
            if(empty($product))
            {
                throw New Exception('Product not found');
            }
            $price=$product[0]->price-($product[0]->price*$product[0]->discount/100);
            OrderDetail::addOrder( [ 'name' =>$request->name,'address' =>$request->address,'pincode' =>$request->pincode,
                'city' =>$request->city,'state' =>$request->state,'price' =>$price,'payment_mode' =>$request->cash_payment,
                'customer_phone' =>session('active_user'),'phone_no' =>$request->phone_number,'product_id'=>$Id,'added_on'=>Carbon::now() ] );

            ProductDetail::updateProduct($Id,['quantity'=>$product[0]->quantity-1]);
            DB::Commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
        
        return redirect('order_successful')->with('success',"Done!!");
    }
    function orderHistory()
    {
        try
        {
            $orders=OrderDetail::ordersproductdetails(session('active_user'));
        }
        catch(Exception $e)
        {
            $array = [ "error"=>$e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return view('order_history',['orders'=>$orders]);
    }
    function orderProducts(CheckOutFormValidation $request)
    {
        $request->validate();
        try{
            $productsIdQuantity= CartDetail::productDetail(session('active_user'),['product_id','quantity']);
        }
        catch(Exception $e)
        {
            $array = [ "error"=>$e->getMessage() ];
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
                if(($product[0]->quantity-1)>=0)
                {
                    try
                    {
                        DB::beginTransaction();
                        OrderDetail::addOrder([ 'name' =>$request->name,'address' =>$request->address,'pincode' =>$request->pincode,
                            'city' =>$request->city,'state' =>$request->state,'price' =>$price,'payment_mode' =>$request->cash_payment,
                            'customer_phone' =>session('active_user'),'phone_no' =>$request->phone_number,'product_id'=>$productId,'added_on'=>Carbon::now()]);
                        
                        ProductDetail::updateProduct($productId,['quantity'=>$product[0]->quantity-1]);
                        CartDetail::deleteCartItems(session('active_user'));
                        DB::Commit();
                    }
                    catch(Exception $e)
                    {
                        DB::rollback();
                        $array = [ "error"=>$e->getMessage() ];
                        return redirect('error')->withInput()->withErrors($array);
                    }
                }
            }
        }
        return redirect('order_successful')->with('success',"Done!!");
    }

    function cancelOrder($id)
     {
         try
         {
            DB::beginTransaction();
            $orderProductid=OrderDetail::productId($id);
            if(empty($orderProductid))
            {
                throw New Exception('Order not found');
            }
            $productIdQuantity= ProductDetail::productQuantity($orderProductid);
            $quantity=$productIdQuantity[0]->quantity;
            OrderDetail::deleteOrder($id);
            ProductDetail::updateProduct($orderProductid,['quantity'=>$quantity+1]);
            DB::Commit();
         }
         catch(Exception $e)
         {
             DB::rollback();
            $array = [ "error"=>$e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
         }
        return redirect('order_history');
     }
    function status()
    {
        //$order=new OrderDetail;
        //foreach($order->product() as $order)
        //dd($order->product()->where('orderId',1)) ;
        return view('order_successful');
    }
    
}
