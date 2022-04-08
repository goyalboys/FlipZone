<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class OrderDetail extends Model
{
    public static function addOrder($data)
    {
        OrderDetail::create($data);
    }
    public static function ordersInnerJoinproductdetails($user)
    {
        $orders=OrderDetail::join('Product_Details','Product_Details.Id','=','Order_Details.product_id')
        ->where('customer_phone',$user)->get();
        return $orders;
    }
    public static function deleteOrder($id)
    {
        OrderDetail::where('orderId',$id)->delete();
    }

    public static function productId($id)
    {
        $product_id=OrderDetail::where('orderId',$id)->get(['product_id']);
        return $product_id[0]->product_id;
    }

    
    
    public function product()
    {
        return $this->belongsTo('ProductDetail');
    }
    protected $fillable=['name' ,'address' ,'pincode' ,'city','state' ,'price','payment_mode' ,'customer_phone' 
    ,'phone_no' ,'product_id','added_on'];
    public $timestamps=false;
}
