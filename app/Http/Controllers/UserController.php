<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\UserDetail;
use Illuminate\Support\Facades\Hash;
use App\UserDetail as user;
class UserController extends Controller
{
    //
    function userRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'email_id' => 'required|email|unique:User_Details',
            'phone_number'=> 'required|integer|unique:User_Details',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]);
        if($validator->fails())
        {
            return redirect('register')
                            -> withInput()
                            -> withErrors($validator);
        }else
        {
            $user_table=new UserDetail;    
            $user_table->name =$request->name;
            $user_table->email_id =$request->email_id;
            $user_table->phone_number =$request->phone_number;
            $user_table->password=Hash::make($request->password);
            $user_table->gender =$request->gender;
            $user_table->type_of_user =$request->type_of_user;
            $user_table->save();
            return redirect('login')->with('success',"Done!!");
        }
    }

    function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [        
            'phone_number'=> 'required|integer|exists:user_details',
            'password' => 'required|min:6',
        ]
        ,
        $messsages = array(
            'phone_number.exists'=>'Phone number is not registered',
        )
    
    );
        if($validator->fails())
        {
            return redirect('login')
                            -> withInput()
                            -> withErrors($validator);
        }else
        {
        
            //$hashed_password= user::select('password')->where('phone_number',$request->phone_number)->get();
          $hashed_password= user::where('phone_number',$request->phone_number)->get();
          //echo user::where('phone_number',$request->phone_number)->get(['password']);
           $normal_password= $request->password;
           $hashed_password=$hashed_password[0]['password'];
           //echo $hashed_password;
            if(Hash::check($normal_password,$hashed_password))
            {
                //$user=user::where('phone_number',$request->phone_number)->get();
                //echo $user;
                session(['active_user' =>$request->phone_number]);
                //echo user::where('phone_number',$request->phone_number)->get(['type_of_user']);
                if(user::where('phone_number',$request->phone_number)->get()[0]->type_of_user=='merchant')
                    return redirect('merchant_dashboard');
                else{
                    return redirect('/');
                }
            }
            else
            {
                return redirect('login')->withInput()->with('error',"Wrong Password");
            }
        }
    }
}