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


    protected $fillable = ['name', 'password', 'email_id','phone_number','gender','type_of_user'];
    public $timestamps=false;
}
