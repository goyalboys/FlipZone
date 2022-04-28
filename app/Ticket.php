<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $timestamps=false;
    protected $fillable=[
        'name',
        'phone',
        'subject',
        'problem'
    ];

    public static function raiseTicket($data)
    {
        return self::create($data);
    }
    public static function deleteTicket($id)
    {
        return self::where('contactId',$id)->delete();
    }
    public static function Ticket($id)
    {
        return self::where('contactId',$id)->find(1);
    }
    public static function allTicket()
    {
        $contacts=self::simplePaginate(12);
        return $contacts;
    }
    
}
