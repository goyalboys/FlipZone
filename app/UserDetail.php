<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserDetail extends Model
{
    public static function addUser($data)
    {
        UserDetail::create($data);
    }
    public static function hashedPassword($data)
    {
        $password=UserDetail::where('phone_number',$data)->get(['password']);
        return $password[0]['password'];
    }
    public static function typeOFuser($data)
    {
        $type_user=UserDetail::where('phone_number',$data)->get()[0]->type_of_user;
        return $type_user;
    }
    public static function presentuserDetail($data)
    {
        $user=UserDetail::where('phone_number',$data)->get();
        return $user;
    }
    public static function updateProfile($phone_no,$data)
    {
        UserDetail::where('phone_number',$phone_no)->update($data);
    }
    public static function changePassword($phone_no,$password)
    {
        UserDetail::where('phone_number',$phone_no)->update($password);
    }


    protected $fillable = ['name', 'password', 'email_id','phone_number','gender','type_of_user'];
    public $timestamps=false;
}
