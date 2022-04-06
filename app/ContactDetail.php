<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    public static function insertData($data)
    {
        ContactDetail::create($data);

    }
    public $timestamps=false;
    protected $fillable=['name','phone','subject','problem'];

}
