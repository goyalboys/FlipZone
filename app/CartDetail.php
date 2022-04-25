<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    protected $fillable=[
        'customercart_phone',
        'product_id',
        'quantity'
    ];
    public $timestamps=false;

    public static function insertData($data)
    {
        return self::create($data);;
    }
    public static function productidQuantity($id)
    {
        $quantity=self::where('product_id',$id)->get(['quantity']);
        return $quantity;
    }
    public static function updateCartitem($id,$quantity)
    {
        return self::where('product_id',$id)->update(['quantity'=>$quantity]);;
    }
    public static function cartProductDetails()
    {
            $productCart= self::join('Product_Details','Product_Details.Id','=','Cart_Details.product_id')
            ->select('Product_Details.Id','Product_Details.product_name','Product_Details.company_name','Product_Details.offer',
            'Product_Details.image_path','Cart_Details.quantity','Product_Details.price','Product_Details.discount')->get();
            return $productCart;
    }
    public static function productidQuantityId($user)
    {
        $productsIdQuantity= self::where('customercart_phone',$user)->get(['product_id','quantity']);
        return $productsIdQuantity;
    }
    public static function deleteCartItems($user)
    {
        return self::where('customercart_phone',$user)->delete();;
    }
    public static function removeProduct($id)
    {
        return  self::where('product_id',$id)->delete();;
    }
    //
}
