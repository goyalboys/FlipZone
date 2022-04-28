<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\session;
use Exception;
use App\Http\Requests\RegistrationFormValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function register()
    {
        return view('register');
    }
    function login(){
        return view('login');
    }
    function userRegistration(RegistrationFormValidation $request)
    {
        $request->validate();
        try
        { 
            DB::beginTransaction();
            UserDetail::addUser([
                'name' =>$request->name,
                'email_id' =>$request->email_id,
                'phone_number' =>$request->phone_number,
                'password'=>Hash::make($request->password),
                'gender' =>$request->gender,
                'type_of_user' =>$request->type_of_user
            ]);
            DB::Commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
            $array = [ "error"=>$e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        return redirect('login')->with('success',"Done!!");
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
                    //login(\Illuminate\Contracts\Auth\Authenticatable $user, bool $remember = false);
                    if(Auth::attempt($request->only('phone_number','password')))
                    {
                        if($type_user=='merchant')
                        {
                            echo Auth::User();
                            return redirect('dashboard');
                        }
                        else
                        {
                            return redirect('/');
                        }
                    }  
                }
                else
                {
                    return redirect('login')->withInput()->with('error',"Wrong Password");
                }
            }
            catch(Exception $e)
            {
                $array = [ "error"=>$e->getMessage() ];
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
        try
        {
            $user= UserDetail::presentuserDetail(session('active_user'));
        }
        catch(Exception $e)
        {
            $array = [ "error"=>$e->getMessage() ];
            return redirect('error')->withInput()->withErrors($array);
        }
        
       
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
            try
            {
                DB::beginTransaction();
                UserDetail::updateProfile(session('active_user'),['name' =>$request->name,'email_id' =>$request->email_id,
                    'gender' =>$request->gender,'type_of_user' =>$request->type_of_user]);
                DB::Commit();
            }
            catch(Exception $e)
            {
                DB::rollback();
                $array = [ "error"=>$e->getMessage() ];
                return redirect('error')->withInput()->withErrors($array);
            }
            
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
                try{
                    DB::beginTransaction();
                    UserDetail::changePassword(session('active_user'),['password'=>$password]);
                    DB::Commit();
                }
                catch(Exception $e)
                {
                    DB::rollback();
                    $array = [ "error"=>$e->getMessage() ];
                    return redirect('error')->withInput()->withErrors($array);
                }
                return redirect('/');
            }
            else
            {
                $array = [ "old_password"=>"old password is not correct" ];
                return redirect('change_password')-> withInput()-> withErrors($array);
            }
        }
    }
}