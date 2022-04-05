<?php

namespace App\Http\Controllers;
use App\ProductDetail as products;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
Use App\CartDetail;
class OrderController extends Controller
{
    //
    function checkOut($Id)
    {
        try{
            $product=products::where('Id',$Id)->get();
            return view('checkout',['product'=>$product]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in checkout product";
        }

    }
    function orderCheck(Request $request,$Id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'pincode'=> 'required|integer',
            'state' => 'required',
            'city' => 'required',
            'phone_number'=>'required|integer',
        ]);
        if($validator->fails())
        {
            return redirect('checkout/'.$Id)-> withInput()-> withErrors($validator);
        }else
        {
            $product=products::where('Id',$Id)->get();
            $orderTable=new OrderDetail;  
            $orderTable->name =$request->name;
            $orderTable->address =$request->address;
            $orderTable->pincode =$request->pincode;
            $orderTable->city =$request->city;
            $orderTable->state =$request->state;
            $orderTable->price =$product[0]->price-($product[0]->price*$product[0]->discount/100);
            $orderTable->payment_mode =$request->cash_payment;
            $orderTable->customer_phone =session('active_user');
            $orderTable->phone_no =$request->phone_number;
            $orderTable->product_id=$Id;
            $orderTable->added_on=Carbon::now();
            $orderTable->save();
            products::where('Id',$Id)->update(['quantity'=>$product[0]->quantity-1]);
            return redirect('order_successful')->with('success',"Done!!");
        }
    }


    function orderHistory()
    {
        try{
            $orders=OrderDetail::join('Product_Details','Product_Details.Id','=','Order_Details.product_id')->where('customer_phone',session('active_user'))->get();
            return view('order_history',['orders'=>$orders]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in order product";
        }
    }
     function checkOutcart(){
        $product_cart= CartDetail::join('Product_Details','Product_Details.Id','=','Cart_Details.product_id')
        ->select('Product_Details.product_name','Product_Details.company_name','Product_Details.offer','Product_Details.image_path','Cart_Details.quantity',
        'Product_Details.price','Product_Details.discount')
        ->get();
        $price=0;
        foreach($product_cart as $product)
        {
            $price+=$product->price-($product->price*$product->discount/100);
        }

        return view('checkoutcart',['products'=>$product_cart,'totalprice'=>$price]);
     }

     function ordersCheckout(Request $request)
     {
       $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'pincode'=> 'required|integer',
            'state' => 'required',
            'city' => 'required',
            'phone_number'=>'required|integer',
        ]);
        if($validator->fails())
        {
            return redirect('checkoutcart/')-> withInput()-> withErrors($validator);
        }else
        {
            $productsIdQuantity= CartDetail::where('customercart_phone',session('active_user'))->get(['product_id','quantity']);
            foreach($productsIdQuantity as $productIdQuantity )
            {
                $productId=$productIdQuantity->product_id;
                $quantity=$productIdQuantity->quantity;
                while($quantity)
                {
                    $quantity--;
                    $product=products::where('Id',$productId)->get();
                    $orderTable=new OrderDetail;  
                    $orderTable->name =$request->name;
                    $orderTable->address =$request->address;
                    $orderTable->pincode =$request->pincode;
                    $orderTable->city =$request->city;
                    $orderTable->state =$request->state;
                    $orderTable->price =$product[0]->price-($product[0]->price*$product[0]->discount/100);
                    $orderTable->payment_mode =$request->cash_payment;
                    $orderTable->customer_phone =session('active_user');
                    $orderTable->phone_no =$request->phone_number;
                    $orderTable->product_id=$productId;
                    $orderTable->added_on=Carbon::now();
                    if(($product[0]->quantity-1)>=0)
                    {
                        $orderTable->save();
                        products::where('Id',$productId)->update(['quantity'=>$product[0]->quantity-1]);
                    }

                }

            }
            CartDetail::where('customercart_phone',session('active_user'))->delete();
            return redirect('order_successful')->with('success',"Done!!");
        }

     }
}
