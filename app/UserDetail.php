<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserDetail extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name', 
        'password', 
        'email_id',
        'phone_number',
        'gender',
        'type_of_user'
    ];
    public $timestamps=false;

    public static function addUser($data)
    {
        return self::create($data);
    }
    public static function getUserPassword($data)
    {
        $password=self::where('phone_number',$data)->get(['password']);
        return $password[0]['password'];
    }
    public static function typeOfUser($data)
    {
        $type_user=self::where('phone_number',$data)->get()[0]->type_of_user;
        return $type_user;
    }
    public static function getActiveUserDetails($data)
    {
        $user=self::where('phone_number',$data)->get();
        return $user;
    }
    public static function updateProfile($phone_no,$data)
    {
        return  self::where('phone_number',$phone_no)->update($data);;
    }
    public static function changePassword($phone_no,$password)
    {
        return self::where('phone_number',$phone_no)->update($password);
    }
}
