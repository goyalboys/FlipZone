<?php

namespace App\Http\Controllers;
use App\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function showProducts()
    {
        $companies=array('Arrow','peter England','Van Heusan','Zodiac','Louise Phillipe','park Avenue');
        $offers=array('Summer Sale','At Low Cost Emi');
        $discounts=array("10%",'20%',"30%","40%",'50%',"60%",'70%',"80%","90%");
        $products=ProductDetail::allProduct();
        return view('products',['products'=>$products,'companies'=>$companies,'offers'=>$offers,'discounts'=>$discounts]);
    }
    function filterApplyPrice(Request $req)
    { 
        $products=ProductDetail::betweenPrice($req['price1'],$req['price2']);
        return response()->json(['products' => $products]);
    }

    function lowtohigh(Request $request)
    {
        $products=ProductDetail::lowTohigh($request['price1'],$request['price2']);      
        return response()->json(['products' => $products]);
    }
    function hightolow(Request $request)
    {
        $products=ProductDetail::highTolow($request['price1'],$request['price2']);      
        return response()->json(['products' => $products]);
    }
    /*function rating(Request $req)
    {
        $products=ProductDetail::orderBy('rating','desc')->where('price','>',$req['price1'])->where('price','<',$req['price2'])->where('quantity','>','0')->get();      
        return response()->json(['products' => $products]);
    }*/
    function product($Id)
    {
        $product=ProductDetail::productIddetail($Id);
        return view('product',['product'=>$product]);
    }

    function searchProduct(Request $request)
    {
        $value=$request['value'];
        $products=ProductDetail::likeProducts($value);
        return response()->json(['item' => $products]);
    }
}
