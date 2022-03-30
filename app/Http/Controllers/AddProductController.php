<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProductDetail;

class AddProductController extends Controller
{
    function presentUser(){
        $user = Auth::user();
        print_r($user);
    }
    //
    function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:200',
            'description' => 'required',
            'price'=> 'required|integer',
            'quantity' => 'required|max:99|integer',
            'discount' => 'required|integer|max:99',
            'company_name'=>'required',
            'image'=>'required',
            'offer'=>'required',
        ]);
        if($validator->fails())
        {
            return redirect('add_product_details')
                            -> withInput()
                            -> withErrors($validator);
        }else
        {
            $product_table=new ProductDetail;  
              
            $product_table->description =$request->description;
            $product_table->product_name =$request->product_name;
            $product_table->company_name =$request->company_name;
            $product_table->offer =$request->offer;
            $product_table->discount =$request->discount;
            $product_table->price =$request->price;
            $product_table->quantity =$request->quantity;
            $product_table->merchant_phone_number =session('active_user');;

            //$product_table->image_path =$request->image;
            //echo $request->file('image');
            //echo"<br>";
            
            $request->image->store('public');
            $product_table->image_path= $request->image->hashName();
            $product_table->save();
            return redirect('merchant_dashboard')->with('success',"Done!!");
        }
    }
}
