<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProductDetail;
use App\OrderDetail;
use File;
Use Exception;
use App\Ticket;
use App\Http\Requests\ProductFormValidation;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    
    function addProduct(ProductFormValidation $request)
    {
        $request->validate();
        try
        {
            ProductDetail::insertProduct(['description' =>$request->description,'product_name' =>$request->product_name,
            'company_name' =>$request->company_name,'offer' =>$request->offer,'discount' =>$request->discount,
            'price' =>$request->price,'quantity' =>$request->quantity,'merchant_phone_number' =>session('active_user'),
            'image_path'=> $request->image->hashName()]);
            $request->image->store('public');
            return redirect('productdetails')->with('success',"Done!!");
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
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


    function editProduct(Request $request,$id)
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

    function editProductDetail(ProductFormValidation $request,$id)
    {
        $request->validate();
        try
        {
            ProductDetail::updateProduct($id,['description'=>$request->description,'product_name'=>$request->product_name,
            'company_name'=>$request->company_name,'offer'=>$request->offer,'discount'=>$request->discount,'price'=>$request->price,
            'quantity'=>$request->quantity]);
            return redirect('productdetails')->with('success',"Done!!");
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
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
        Ticket::deleteTicket($id);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
        }
        return redirect('merchant_dashboard');
    }

    function dashboard()
    {
        return view('merchant_dashboard',['problems'=>Ticket::allTicket()]);
    }

    function ProductPage()
    {
        return view('add_product_detail');
    }
    
}
