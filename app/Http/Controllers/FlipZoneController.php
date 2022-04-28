<?php

namespace App\Http\Controllers;
use App\ProductDetail;
use Illuminate\Http\Request;
use App\Ticket;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Requests\TicketFormValidation;
use Auth;
use Illuminate\Support\Facades\DB;

class FlipZoneController extends Controller
{
   
    function contactPage()
    {
        return view('contact_us');
    }
    function errorPage()
    {
        return view('error');
    }
    function aboutPage()
    {
        return view('about_us');
    }

    function showContent()
    {
        try
        {
            $products=ProductDetail::getLimitedProduct(4);
            
        }
        catch(Exception $e)
        {
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return view('main',['products' => $products]);
    }
    function ticket(TicketFormValidation $request)
    {
        $request->validate();
        try
        {
            DB::beginTransaction();
            Ticket::raiseTicket(
            [
                'name' =>$request->name,
                'phone' =>$request->phone_number,
                'problem' =>$request->problem,
                'subject' =>$request->subject
            ]);
            DB::Commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            $array = [ "error" => $e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('/');
    }
}
