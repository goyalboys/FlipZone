<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductDetail;
use App\OrderDetail;

class ApiController extends Controller
{
    //
    function show(Request $request)
    {
        if($request->page)
            $page_number= $request->page;
        else {
            $page_number=1;
        }
        $pagination=20;
        $end=$page_number*$pagination;
        $start=($page_number-1)*$pagination;

        try
        {
            $products=ProductDetail::showProductspaginate(['start'=>$start,'end'=>$end]);
        }
        catch(Exception $e)
        {
           $array = [
               "error"=>$e->getMessage()
           ];
           return redirect('error')->withInput()->withErrors($array);
        }
        return $products;
    }
    function order($Id)
    {
        $order=OrderDetail::orderDetail($Id);
        return $order;
    }
    function product($Id)
    {
        try{
            $product=ProductDetail::productIddetail($Id);
        }
        catch(Exception $e)
        {
           $array = [
               "error"=>$e->getMessage()
           ];
           return $array;
        }
        return $product;
    }
    function showByname()
    {

    }
}
