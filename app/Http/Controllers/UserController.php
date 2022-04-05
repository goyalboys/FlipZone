<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\UserDetail;
use Illuminate\Support\Facades\Hash;
use App\UserDetail as user;
class UserController extends Controller
{
    function userRegistration(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:200',
                'email_id' => 'required|email|unique:User_Details',
                'phone_number'=> 'required|integer|unique:User_Details',
                'password' => 'required|min:6',
                'password_confirmation' => 'required|min:6|same:password',
            ]);
        }
        catch(Excecption $e)
        {
            dd($e->getMessage());
        }
        if($validator->fails())
        {
            try{
                return redirect('register')-> withInput()-> withErrors($validator);
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
        }else
        {
            try{
                $userTable=new UserDetail;    
                $userTable->name =$request->name;
                $userTable->email_id =$request->email_id;
                $userTable->phone_number =$request->phone_number;
                $userTable->password=Hash::make($request->password);
                $userTable->gender =$request->gender;
                $userTable->type_of_user =$request->type_of_user;
                $userTable->save();
                return redirect('login')->with('success',"Done!!");
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
        }
    }

    function userLogin(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [        
                'phone_number'=> 'required|integer|exists:user_details',
                'password' => 'required|min:6',
            ]
            ,
            $messsages = array(
                'phone_number.exists'=>'Phone number is not registered',
            )
        
            );
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
        }

        if($validator->fails())
        {
            try{
                return redirect('login')-> withInput()-> withErrors($validator);
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
        }else
        {
            try{
                $hashedPassword= user::where('phone_number',$request->phone_number)->get();
                $normalPassword= $request->password;
                $hashedPassword=$hashedPassword[0]['password'];
                if(Hash::check($normalPassword,$hashedPassword))
                {
                    session(['active_user' =>$request->phone_number]);
                    $type_user=user::where('phone_number',$request->phone_number)->get()[0]->type_of_user;
                    session(['type_user' =>$type_user]);
                    if($type_user=='merchant')
                    {
                        return redirect('merchant_dashboard');
                    }
                    else{
                        return redirect('/');
                    }
                }
                else
                {
                    return redirect('login')->withInput()->with('error',"Wrong Password");
                }
            }
            catch(Exception $e)
            {
                dd($e->getMessage());
            }
        }
    }
}