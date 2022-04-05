<?php

namespace App\Http\Controllers;
use App\ProductDetail as products;
use Illuminate\Http\Request;
use App\ContactDetail;
use Illuminate\Support\Facades\Validator;

class FlipZoneController extends Controller
{
    function showContent()
    {
        try{
            return view('main',['products'=>products::all()->where('quantity','>','0')->take(4)]);
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            echo "error in showing content to main page";
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
        else{
            $contactDetail=new ContactDetail();
            $contactDetail->name=$request->name;
            $contactDetail->phone=$request->phone_number;
            $contactDetail->problem=$request->problem;
            $contactDetail->subject=$request->subject;
            $contactDetail->save();
            return redirect('/');
        }
    }
}
