<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProductDetail;
use App\OrderDetail;
use File;
class DashboardProductController extends Controller
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
            $product_table->merchant_phone_number =session('active_user');
            //$product_table->image_path =$request->image;
            //echo $request->file('image');
            //echo"<br>";
            $request->image->store('public');
            $product_table->image_path= $request->image->hashName();
            $product_table->save();
            return redirect('productdetails')->with('success',"Done!!");
        }
    }

    function productDetails()
    {
        $product=Productdetail::all()->where('merchant_phone_number',session('active_user'));
        //echo "hi";
        //$product=OrderDetail::join('Product_Details','Product_Details.Id','=','Order_Details.product_id')
        //->where('merchant_phone_number',session('active_user'))->get();
        //echo $product;

        return view('productdetails',['products'=>$product]);

    }

    function orderReceived()
    {
        //echo "hi";
        $product=OrderDetail::join('Product_Details','Product_Details.Id','=','Order_Details.product_id')
        ->where('merchant_phone_number',session('active_user'))->get();
        //echo $product;
        return view('order_receive',['products'=>$product]);
    }

    function editProductView(Request $request,$id)
    {
        //echo $id;
        $product=ProductDetail::all()->where('Id',$id);
        //echo $product;
        return view('edit_product_details',['product'=>$product,'id'=>$id]);

    }

    function editProductDetail(Request $request,$id)
    {
        echo "hi";
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:200',
            'description' => 'required',
            'price'=> 'required|integer',
            'quantity' => 'required|max:99|integer',
            'discount' => 'required|integer|max:99',
            'company_name'=>'required',
            'offer'=>'required',
        ]);
        if($validator->fails())
        {
            return redirect('editproduct/$request->id')
                            -> withInput()
                            -> withErrors($validator);
        }
        else
        {
           // $product_table=new ProductDetail;  
            ProductDetail::where('Id',$id)->update(['description'=>$request->description,'product_name'=>$request->product_name,'company_name'=>$request->company_name,'offer'=>$request->offer,'discount'=>$request->discount,'price'=>$request->price,'quantity'=>$request->quantity]);
            return redirect('productdetails')->with('success',"Done!!");
        }
    
    }

    function deleteProduct($id)
    {
        $image_path = "storage/".ProductDetail::where('Id', $id)->get(['image_path'])[0]->image_path;
        ProductDetail::where('Id', $id)->delete();
            File::delete($image_path);
        return redirect('productdetails')->with('success',"Done!!");
    }

}
