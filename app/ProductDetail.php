<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    public static function insertProduct($data)
    {
        ProductDetail::Create($data);
    }
    public static function showLimitedProduct($data)
    {
        $product=ProductDetail::all()->where('quantity','>','0')->take($data);
        return $product;
    }
    public static function allProduct()
    {
        $product=ProductDetail::where('quantity','>','0')->paginate(12);
        return $product;
    }

    public static function betweenPrice($price1,$price2)
    {
        $product=    ProductDetail::all()->where('price','>',$price1)->where('price','<',$price2)->where('quantity','>','0');
        return $product;
    }
    public static function lowTohigh($price1,$price2)
    {
        $product=ProductDetail::orderBy('price')->where('price','>',$price1)->where('price','<',$price2)->where('quantity','>','0')->get();
        return $product;
    }
    public static function highTolow($price1,$price2)
    {
        $product=ProductDetail::orderBy('price','desc')->where('price','>',$price1)->where('price','<',$price2)->where('quantity','>','0')->get();
        return $product;
    }
    public  static function productIddetail($Id)
    {
       $product=ProductDetail::where('Id',$Id)->where('quantity','>','0')->get();
       return $product;
    }
    public static function likeProducts($value)
    {
        $products=ProductDetail::where('product_name','like','%'.$value.'%')->orWhere('company_name', 'like', '%'.$value.'%')->orWhere('description', 'like', '%'.$value.'%')->get();
        return $products;
    }

    public static function merchantProducts($merchantPhoneNumber)
    {
        $products=Productdetail::all()->where('merchant_phone_number',session('active_user'));
        return $products;
    }
    public static function merchantProductIddetail($id)
    {
        $products=ProductDetail::all()->where('Id',$id);
        return $products;
    }
    public static function productImagepath($id)
    {
        $imagePath=ProductDetail::where('Id', $id)->get(['image_path'])[0]->imagePath;
        return $imagePath;
    }
    public static function deleteProduct($id)
    {
        ProductDetail::where('Id', $id)->delete();
        
    }
    public static function updateProduct($id,$data)
    {
        ProductDetail::where('Id',$id)->update($data);
    }
    public static function updateproductQuantity($id,$quantity)
    {
        ProductDetail::where('Id',$id)->update($quantity);
    }
    public static function productIdDetails($id)
    {
        $product=ProductDetail::where('Id',$id)->get();
        return $product;
    }
    public static function productQuantity($id)
    {
        $quantity=ProductDetail::where('Id',$id)->get(['quantity']);
        return $quantity;
    }
    public static function updateQuantity($id,$quantity)
    {
        ProductDetail::where('Id',$id)->update(['quantity'=>$quantity]);
    }
    
    protected $fillable=['description','product_name','company_name','offer','discount','price','quantity','merchant_phone_number','image_path'];
    public $timestamps=false;
}
