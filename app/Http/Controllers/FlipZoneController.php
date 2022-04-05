<?php

namespace App\Http\Controllers;
use App\ProductDetail as products;
use Illuminate\Http\Request;

class FlipZoneController extends Controller
{
    function showContent()
    {
        try{
            return view('main',['products'=>products::all()->take(4)]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in showing content to main page";
        }
    }
}
