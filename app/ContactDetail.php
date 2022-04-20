<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    public static function insertData($data)
    {
        ContactDetail::create($data);
        return "contact created";

    }
    public static function deleteContact($id)
    {
        ContactDetail::where('contactId',$id)->delete();
        return "contact deleted";
    }
    public static function allRow()
    {
        $contacts=ContactDetail::all();
        return $contacts;
    }
    public $timestamps=false;
    protected $fillable=['name','phone','subject','problem'];

}
