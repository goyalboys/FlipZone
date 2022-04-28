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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function addProduct(ProductFormValidation $request)
    {
        $request->validate();
        try
        {
            DB::beginTransaction();
            ProductDetail::insertProduct( 
            [
                'description' => $request->description,
                'product_name' => $request->product_name,
                'company_name' => $request->company_name,
                'offer' => $request->offer,
                'discount' => $request->discount,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'merchant_phone_number' => session('active_user'),
                'image_path'=> $request->image->hashName()
            ]);
            $request->image->store('public');
            DB::Commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('merchant_products')->with('success',"Done!!");
        
    }
    function productDetails()
    {
        try
        {
            $products=Productdetail::getMerchantAddedProducts( session('active_user') );
        }
        catch(Exception $e)
        {
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return view('dashboard.products',[ 'products' => $products ]);
    }


    function editProduct(Request $request,$id)
    {
        try
        {
            $products=ProductDetail::getProductDetailsById($id);
            if( empty( $products ) )
            {
                $array = [ "error" => "Page Doesnot Exit" ];
                return redirect('error')->withInput()->withErrors($array);
            }
        }
        catch(exception $e)
        {
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        foreach($products as $product)
            return view('dashboard.edit_product',['product' => $product,'id' => $id]);
    }

    function editProductDetails(ProductFormValidation $request,$id)//requeset form should be custom
    {
        $request->validate();
        try
        {
            $products=ProductDetail::getProductDetailsById($id);
            if(empty($products))
            {
                $array = [ "error"=>"Page Doesnot Exit" ];
                return redirect('error')->withInput()->withErrors($array);
            }
            DB::beginTransaction();
            ProductDetail::updateProductById( $id , 
            [
                'description' => $request->description,
                'product_name' => $request->product_name,
                'company_name' => $request->company_name,
                'offer' => $request->offer,
                'discount' => $request->discount,
                'price' => $request->price,
                'quantity' => $request->quantity 
            ]);
            DB::Commit();
            
        }
        catch(Exception $e)
        {
            DB::rollback();
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('merchant_products')->with('success',"Done!!");
    }

    function deleteProduct($id)
    { 
        try
        {
            $products=ProductDetail::getProductDetailsById($id);
            if(empty($products))
            {
                $array = [ "error" => "Page Doesnot Exit" ];
                return redirect('error')->withInput()->withErrors($array);
            }
            $imagePath = "storage/".ProductDetail::getProductImagepath($id);
            DB::beginTransaction();
            ProductDetail::deleteProductById($id);
            File::delete($imagePath);
            DB::Commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            $array = [ "error"=>$e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('merchant_products')->with('success',"Done!!");
    }

    function resolved($id)
    {
        try
        {
            if(empty(Ticket::getTicketDetailsById($id)))
            {
                $array = [ "error" => "Ticket not exits" ];
                return redirect('error')->withInput()->withErrors($array);
            }
            DB::beginTransaction();
            Ticket::deleteTicketById($id);
            DB::Commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('dashboard');
    }
    function orderReceived()
    {
        try
        {
            $orders=OrderDetail::getOrderedProductDetails(session('active_user'));
        }
        catch(Exception $e)
        {
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return view('dashboard.order_receive',['products' => $orders]);
    }

    function dashboard()
    {
        return view('dashboard.dashboard',['problems' => Ticket::allTicket()]);
    }

    function ProductPage()
    {
        return view('dashboard.add_product');
    }
    
}
