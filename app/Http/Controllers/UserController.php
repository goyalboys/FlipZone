<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\session;
use Exception;

class UserController extends Controller
{
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
            return redirect('register')-> withInput()-> withErrors($validator);
        }
        else
        {
            try
            {  
                UserDetail::addUser(['name' =>$request->name,
                'email_id' =>$request->email_id,
                'phone_number' =>$request->phone_number,
                'password'=>Hash::make($request->password),
                'gender' =>$request->gender,
                'type_of_user' =>$request->type_of_user]);
                return redirect('login')->with('success',"Done!!");
            }
            catch(Exception $e)
            {
                $array = [
                    "error"=>$e->getMessage()
                ];
                return redirect('error')->withInput()->withErrors($array);
            }
        }
    }

    function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [        
            'phone_number'=> 'required|integer|exists:user_details',
            'password' => 'required|min:6',
        ]
        );
        if($validator->fails())
        {
            return redirect('login')-> withInput()-> withErrors($validator);
        }
        else
        {
            try
            {
                $hashedPassword= UserDetail::hashedPassword($request->phone_number);
                $normalPassword= $request->password;
                if(Hash::check($normalPassword,$hashedPassword))
                {
                    session(['active_user' =>$request->phone_number]);
                    $type_user=UserDetail::typeOFuser($request->phone_number);
                    session(['type_user' =>$type_user]);
                    if($type_user=='merchant')
                    {
                        return redirect('merchant_dashboard');
                    }
                    else
                    {
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
                $array = [
                    "error"=>$e->getMessage()
                ];
                return redirect('error')->withInput()->withErrors($array);
            }
        }
    }
    function logout()
    {
        session::flush();
        return redirect('login');
    }

    function editProfile()
    {
       $user= UserDetail::presentuserDetail(session('active_user'));
        return view('edit_profile',['user'=>$user[0]]);
    }
    function changePassword()
    {
        return view('change_password');
    }
    function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'email_id' => 'required|email',
        ]);
        if($validator->fails())
        {
            return redirect('edit_profile')-> withInput()-> withErrors($validator);
        }
        else
        {
            UserDetail::updateProfile(session('active_user'),['name' =>$request->name,'email_id' =>$request->email_id,
            'gender' =>$request->gender,'type_of_user' =>$request->type_of_user]);
            return redirect('/');
        }
    }
    function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [    
            'old_password'   =>'required|min:6',
            'password'=> 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]
        );
        if($validator->fails())
        {
            $messages = $validator->messages();
            return redirect('change_password')-> withInput()-> withErrors($validator);
        }
        else
        {
            $hashedPassword= UserDetail::hashedPassword(session('active_user'));
            $normalPassword= $request->old_password;
            if(Hash::check($normalPassword,$hashedPassword))
            {
                $password=Hash::make($request->password);
                UserDetail::changePassword(session('active_user'),['password'=>$password]);
                return redirect('/');
            }
            else
            {
                $array = [
                    "old_password"=>"old password is not correct"
                ];
                return redirect('change_password')-> withInput()-> withErrors($array);
            }
        }
    }
}