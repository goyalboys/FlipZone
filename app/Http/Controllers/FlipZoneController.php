<?php

namespace App\Http\Controllers;
use App\ProductDetail;
use Illuminate\Http\Request;
use App\ContactDetail;
use Illuminate\Support\Facades\Validator;
use Exception;

class FlipZoneController extends Controller
{
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
    function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'problem' => 'required',
            'phone_number'=> 'required|integer',
            'subject' => 'required',
        ]);
        if($validator->fails())
        {
            return redirect('contact_us/')-> withInput()-> withErrors($validator);
        }
        else
        {
            try
            {
                ContactDetail::insertData(['name'=>$request->name,'phone'=>$request->phone_number,
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
}
