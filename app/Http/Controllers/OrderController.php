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
        $product=products::where('Id',$Id)->get();
        return view('checkout',['product'=>$product]);

    }
    function orderCheck(Request $request,$Id)
    {
        //echo "hi";
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
            $id=1;
            return redirect('checkout/'.$id)
                            -> withInput()
                            -> withErrors($validator);
        }else
        {
            //echo "hi";
            $product=products::where('Id',$Id)->get();
            //echo $product;
            
            $order_table=new OrderDetail;  
            $order_table->name =$request->name;
            $order_table->address =$request->address;
            $order_table->pincode =$request->pincode;
            $order_table->city =$request->city;
            $order_table->state =$request->state;
            $order_table->price =$product[0]->price-($product[0]->price*$product[0]->discount/100);
            $order_table->payment_mode =$request->cash_payment;
            $order_table->customer_phone =session('active_user');
            $order_table->phone_no =$request->phone_number;
            $order_table->product_id=$Id;
            $order_table->added_on=Carbon::now();
            //$product_table->image_path =$request->image;
            //echo $request->file('image');
            //echo"<br>";
            $order_table->save();
            products::where('Id',$Id)->update(['quantity'=>$product[0]->quantity-1]);
            return redirect('order_successful')->with('success',"Done!!");
        }
    }


    function orderHistory()
    {
        $orders=OrderDetail::join('Product_Details','Product_Details.Id','=','Order_Details.product_id')->where('customer_phone',session('active_user'))->get();
        //echo OrderDetail->product();
        //echo $orders->product();
        //echo $product;
        return view('order_history',['orders'=>$orders]);
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
            $id=1;
            return redirect('checkout/'.$id)
                            -> withInput()
                            -> withErrors($validator);
        }else
        {
            //echo "hi";
            //echo $product;
            $productsIdQuantity= CartDetail::where('customercart_phone',session('active_user'))->get(['product_id','quantity']);
            foreach($productsIdQuantity as $productIdQuantity )
            {
                $productId=$productIdQuantity->product_id;
                $quantity=$productIdQuantity->quantity;
                while($quantity)
                {
                    $quantity--;
                    $product=products::where('Id',$productId)->get();
                    $order_table=new OrderDetail;  
                    $order_table->name =$request->name;
                    $order_table->address =$request->address;
                    $order_table->pincode =$request->pincode;
                    $order_table->city =$request->city;
                    $order_table->state =$request->state;
                    $order_table->price =$product[0]->price-($product[0]->price*$product[0]->discount/100);
                    $order_table->payment_mode =$request->cash_payment;
                    $order_table->customer_phone =session('active_user');
                    $order_table->phone_no =$request->phone_number;
                    $order_table->product_id=$productId;
                    $order_table->added_on=Carbon::now();
                    $order_table->save();
                    products::where('Id',$productId)->update(['quantity'=>$product[0]->quantity-1]);
                }

            }
            CartDetail::where('customercart_phone',session('active_user'))->delete();
            return redirect('order_successful')->with('success',"Done!!");
        }

     }
}
