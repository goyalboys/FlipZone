<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
    public static function hashedPassword($data)
    {
        $password=self::where('phone_number',$data)->get(['password']);
        return $password[0]['password'];
    }
    public static function typeOFuser($data)
    {
        $type_user=self::where('phone_number',$data)->get()[0]->type_of_user;
        return $type_user;
    }
    public static function presentuserDetail($data)
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
