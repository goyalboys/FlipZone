<?php

namespace App\Http\Controllers;
use App\ProductDetail;
use Illuminate\Http\Request;
use Exception;

class ProductController extends Controller
{
    function showProducts()
    {
        $companies=array('Arrow','peter England','Van Heusan','Zodiac','Louise Phillipe','park Avenue');
        $offers=array('Summer Sale','At Low Cost Emi');
        $discounts=array("10%",'20%',"30%","40%",'50%',"60%",'70%',"80%","90%");
        try
        {
            $products=ProductDetail::getAllProducts();
        }
        catch(Exception $e)
        {
           $array = [ "error" => $e->getMessage() ];
           return redirect('error')->withInput()->withErrors($array);
        }
        return view('products',['products'=>$products,'companies'=>$companies,'offers'=>$offers,'discounts'=>$discounts]);
    }

    function filterApplyPrice(Request $req)
    {
        try
        {
            $products=ProductDetail::getAllProducts( $req['price1'], $req['price2'], 3);  //3 for filter
        }
        catch(Exception $e)
        {
           $array = [ "error" => $e->getMessage() ];
           return redirect('error')->withInput()->withErrors($array);
        }
        return response()->json(['products' => $products]);
    }

    function lowtohigh(Request $request)
    {
        try
        {
            $products=ProductDetail::getAllProducts(1,1000,1);      // 1 for LOW TO HIGH 
        }
        catch(Exception $e)
        {
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }

        return response()->json(['products' => $products]);
        //return view('product_item',['products'=>$products])->render();
    }

    function hightolow(Request $request)
    {
        try
        {
            $products=ProductDetail::getAllProducts($request['price1'],$request['price2'],2);    //2 for high to low  
        }
        catch(Exception $e)
        {
           $array = [ "error" => $e->getMessage() ];
           return redirect('error')->withInput()->withErrors($array);
        }
        return response()->json(['products' => $products]);
    }   
    function product($id)
    {
        try{
            $product=ProductDetail::getProductDetailsById($id);
            if(empty($product))
                {
                    $array = [ "error"=>"Page does not Exit" ];
                    return redirect('error')->withInput()->withErrors($array);
                }
        }
        catch(Exception $e)
        {
           $array = [ "error" => $e->getMessage() ];
           return redirect('error')->withInput()->withErrors($array);
        }
        return view('product',['product'=>$product]);
    }
    function discountProduct(Request $request)
    {
        try
        {
            $products=ProductDetail::getProductHasMoreThanThisDiscount($request['discount']);
        }
        catch(Exception $e)
        {
           $array = [ "error" => $e->getMessage() ];
           return redirect('error')->withInput()->withErrors($array);
        }
        return response()->json(['products' => $products]);
    }
    function searchProduct(Request $request)
    {
        try
        {
            $value=$request['value'];
            $products=ProductDetail::getLikeProducts($value);
        }
        catch(Exception $e)
        {
           $array = [ "error" => $e->getMessage() ];
           return redirect('error')->withInput()->withErrors($array);
        }
        return response()->json(['item' => $products]);
    }
    /*
    function rating(Request $req)
    {
        $products=ProductDetail::orderBy('rating','desc')->where('price','>',$req['price1'])->where('price','<',$req['price2'])->where('quantity','>','0')->get();      
        return response()->json(['products' => $products]);
    }
    */ 
}
