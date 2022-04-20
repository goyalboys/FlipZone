<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    public static function insertData($data)
    {
        CartDetail::create($data);
        return "created";
    }
    public static function productidQuantity($id)
    {
        $quantity=CartDetail::where('product_id',$id)->get(['quantity']);
        return $quantity;
    }
    public static function updateCartitem($id,$quantity)
    {
        CartDetail::where('product_id',$id)->update(['quantity'=>$quantity]);
        return "cart item updated";
    }
    public static function cartInnerjoinProductDetails()
    {
            $productCart= CartDetail::join('Product_Details','Product_Details.Id','=','Cart_Details.product_id')
            ->select('Product_Details.Id','Product_Details.product_name','Product_Details.company_name','Product_Details.offer',
            'Product_Details.image_path','Cart_Details.quantity','Product_Details.price','Product_Details.discount')->get();
            return $productCart;
    }
    public static function productidQuantityId($user)
    {
        $productsIdQuantity= CartDetail::where('customercart_phone',$user)->get(['product_id','quantity']);
        return $productsIdQuantity;
    }
    public static function deleteCartItems($user)
    {
        CartDetail::where('customercart_phone',$user)->delete();
        return "cart item deleted";
    }
    public static function removeProduct($id)
    {
        CartDetail::where('product_id',$id)->delete();
        return "product removed";
    }

    protected $fillable=['customercart_phone','product_id','quantity'];
    

    public $timestamps=false;
    //
}
