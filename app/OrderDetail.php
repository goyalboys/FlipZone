<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\ProductDetail;

class OrderDetail extends Model
{
    protected $fillable=[
        'name' ,
        'address' ,
        'pincode' ,
        'city',
        'state' ,
        'price',
        'payment_mode' ,
        'customer_phone' 
        ,'phone_no' ,
        'product_id',
        'added_on'
    ];
    public $timestamps=false;
    public static function addOrder($data)
    {
        
        return self::create($data);
    }
    public static function ordersproductdetails($user)
    {
        $orders=self::join('Product_Details','Product_Details.Id','=','Order_Details.product_id')
            ->where('customer_phone',$user)->get();
        return $orders;
    }
    public static function deleteOrder($id)
    {
        return self::where('orderId',$id)->delete();
    }
    public static function productId($id)
    {
        $product_id=self::where('orderId',$id)->get(['product_id']);
        return $product_id[0]->product_id;
    }
    public function product()
    {
        return self::belongsToMany('App\ProductDetail');
       // return self::belongsToMany(ProductDetail::class, 'Id', 'product_id');

        
    }
    public static function orderDetail($id)
    {
        return self::where('orderId',$id)->get();
    }
}
