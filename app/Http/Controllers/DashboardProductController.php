<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProductDetail;
use App\OrderDetail;
use File;
Use Exception;
use App\ContactDetail;

class DashboardProductController extends Controller
{
    function presentUser(){
        $user = Auth::user();
        print_r($user);
    }
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
            return redirect('add_product_details')-> withInput()-> withErrors($validator);
        }
        else
        {
            try
            {
                ProductDetail::insertProduct(['description' =>$request->description,'product_name' =>$request->product_name,'company_name' =>$request->company_name,'offer' =>$request->offer,'discount' =>$request->discount,'price' =>$request->price,'quantity' =>$request->quantity,'merchant_phone_number' =>session('active_user'),'image_path'=> $request->image->hashName()]);
                $request->image->store('public');
                return redirect('productdetails')->with('success',"Done!!");
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
        }
    }

    function productDetails()
    {
        try
        {
            $products=Productdetail::merchantProducts(session('active_user'));
            return view('productdetails',['products'=>$products]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
        }
    }


    function editProductView(Request $request,$id)
    {
        try
        {
            $products=ProductDetail::merchantProductIddetail($id);
            foreach($products as $product)
                return view('edit_product_details',['product'=>$product,'id'=>$id]);
        }
        catch(exception $e)
        {
            dd($e->getMessage());
        }
    }

    function editProductDetail(Request $request,$id)
    {
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
            return redirect('editproduct/$request->id')-> withInput()-> withErrors($validator);
        }
        else
        {
            try
            {
                ProductDetail::updateProduct($id,['description'=>$request->description,'product_name'=>$request->product_name,'company_name'=>$request->company_name,'offer'=>$request->offer,'discount'=>$request->discount,'price'=>$request->price,'quantity'=>$request->quantity]);
                return redirect('productdetails')->with('success',"Done!!");
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
        }
    }

    function deleteProduct($id)
    {
        try
        {
            $imagePath = "storage/".ProductDetail::productImagepath($id);
            try
            {
                ProductDetail::deleteProduct($id);
                File::delete($imagePath);
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
            return redirect('productdetails')->with('success',"Done!!");
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
        }
    }
    function resolved($id)
    {
        try
        {
        ContactDetail::deleteContact($id);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
        }
        return redirect('merchant_dashboard');
    }
    function dashboard()
    {
        return view('merchant_dashboard',['problems'=>ContactDetail::allRow()]);
    }

}
