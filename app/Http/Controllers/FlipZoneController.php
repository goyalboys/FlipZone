<?php

namespace App\Http\Controllers;
use App\ProductDetail as products;
use Illuminate\Http\Request;

class FlipZoneController extends Controller
{
    //
    function showContent()
    {
       
        //$filename= user::where('id',7)->get()[0]['image_path'];
        //echo storage_public('app/' . $filename);
        return view('main',['products'=>products::all()]);
      /*  try{
            echo user::all();
            throw new Exception("hello");
        }
        catch(Exception $e)
        {
            echo "hello";
        }
        
        */

    }
}
