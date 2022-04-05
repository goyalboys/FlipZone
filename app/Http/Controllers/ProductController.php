<?php

namespace App\Http\Controllers;
use App\ProductDetail as products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function showProducts()
    {
        $companies=array('Arrow','peter England','Van Heusan','Zodiac','Louise Phillipe','park Avenue');
        $offers=array('Summer Sale','At Low Cost Emi');
        $discounts=array("10%",'20%',"30%","40%",'50%',"60%",'70%',"80%","90%");
        return view('products',['products'=>products::all(),'companies'=>$companies,'offers'=>$offers,'discounts'=>$discounts]);

    }
    function filterApplyPrice(Request $req)
    { 
        $products=products::all()->where('price','>',$req['price1'])->where('price','<',$req['price2']);       
        return response()->json(['products' => $products]);
    }

    function lowtohigh(Request $req)
    {
        $products=products::orderBy('price')->where('price','>',$req['price1'])->where('price','<',$req['price2'])->get();      
        return response()->json(['products' => $products]);
    }
    function hightolow(Request $req)
    {
        $products=products::orderBy('price','desc')->where('price','>',$req['price1'])->where('price','<',$req['price2'])->get();      
        return response()->json(['products' => $products]);
    }
    function rating(Request $req)
    {
        $products=products::orderBy('rating','desc')->where('price','>',$req['price1'])->where('price','<',$req['price2'])->get();      
        return response()->json(['products' => $products]);
    }
    function product($Id)
    {
        $product=products::where('Id',$Id)->get();
        return view('product',['product'=>$product]);
    }

    function searchProduct(Request $request)
    {
        $value= $request['value'];
        $products=products::where('product_name','like','%'.$value.'%')->orWhere('company_name', 'like', '%'.$value.'%')->orWhere('description', 'like', '%'.$value.'%')->get();
        return response()->json(['item' => $products]);
    }
}
