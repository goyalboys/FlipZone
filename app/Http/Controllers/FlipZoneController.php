<?php

namespace App\Http\Controllers;
use App\ProductDetail;
use Illuminate\Http\Request;
use App\Ticket;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Requests\TicketFormValidation;

class FlipZoneController extends Controller
{
    function register()
    {
        return view('register');
    }
    function login(){
        return view('login');
    }
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
            return view('main',['products'=>ProductDetail::showLimitedProduct(4)]);
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
    }
    function ticket(TicketFormValidation $request)
    {
        $request->validate();
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'problem' => 'required',
        //     'phone_number'=> 'required|integer',
        //     'subject' => 'required',
        // ]);

        // if($validator->fails())
        // {
        //     return redirect('contact_us/')-> withInput()-> withErrors($validator);
        // }
        try
        {
            Ticket::raiseTicket(['name'=>$request->name,'phone'=>$request->phone_number,
            'problem'=>$request->problem,'subject'=>$request->subject,]);
        }
        catch(Exception $e)
        {
            $array = [
                "error"=>$e->getMessage()
            ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('/');
    }
}
