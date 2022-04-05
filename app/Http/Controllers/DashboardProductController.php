<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProductDetail;
use App\OrderDetail;
use File;
Use Exception;

class DashboardProductController extends Controller
{
    function presentUser(){
        $user = Auth::user();
        print_r($user);
    }
    //
    function addProduct(Request $request)
    {
        try{
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
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "Error in  add product validator";
        }
        if($validator->fails())
        {
            try{
                return redirect('add_product_details')-> withInput()-> withErrors($validator);
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
                echo "error  add product validator  fails in Redirect";
            }
        }else
        {
            try{
                $productTable=new ProductDetail;
                $productTable->description =$request->description;
                $productTable->product_name =$request->product_name;
                $productTable->company_name =$request->company_name;
                $productTable->offer =$request->offer;
                $productTable->discount =$request->discount;
                $productTable->price =$request->price;
                $productTable->quantity =$request->quantity;
                $productTable->merchant_phone_number =session('active_user');
                $request->image->store('public');
                $productTable->image_path= $request->image->hashName();
                $productTable->save();
                return redirect('productdetails')->with('success',"Done!!");
            }
            catch(Exception $e){
                dd($e->getMessage());
                echo "error in adding product in database";

            }
        }
    }

    function productDetails()
    {
        try{
            $product=Productdetail::all()->where('merchant_phone_number',session('active_user'));
            return view('productdetails',['products'=>$product]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in showing product details";
        }
    }

    function orderReceived()
    {
        try{
            $product=OrderDetail::join('Product_Details','Product_Details.Id','=','Order_Details.product_id')
            ->where('merchant_phone_number',session('active_user'))->get();
            return view('order_receive',['products'=>$product]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in order received";
        }
    }

    function editProductView(Request $request,$id)
    {
        try{
            $product=ProductDetail::all()->where('Id',$id);
            return view('edit_product_details',['product'=>$product,'id'=>$id]);
        }
        catch(exception $e)
        {
            dd($e->getMessage());
            echo "error in showing clicked product view";
        }
    }

    function editProductDetail(Request $request,$id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'product_name' => 'required|max:200',
                'description' => 'required',
                'price'=> 'required|integer',
                'quantity' => 'required|max:99|integer',
                'discount' => 'required|integer|max:99',
                'company_name'=>'required',
                'offer'=>'required',
            ]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in validator of edit product detail";
        }
        if($validator->fails())
        {
            try{
                return redirect('editproduct/$request->id')-> withInput()-> withErrors($validator);
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
                echo "redirection edit product  request id ";
            }
        }
        else
        {
            try{
            ProductDetail::where('Id',$id)->update(['description'=>$request->description,'product_name'=>$request->product_name,'company_name'=>$request->company_name,'offer'=>$request->offer,'discount'=>$request->discount,'price'=>$request->price,'quantity'=>$request->quantity]);
            return redirect('productdetails')->with('success',"Done!!");
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
                echo "error in updating product details";
            }
        }
    }

    function deleteProduct($id)
    {
        try{
        $imagePath = "storage/".ProductDetail::where('Id', $id)->get(['image_path'])[0]->imagePath;
        ProductDetail::where('Id', $id)->delete();
            File::delete($imagePath);
        return redirect('productdetails')->with('success',"Done!!");
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in deleting product";
        }
    }

}
