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
    public static function allProducts($price1=0,$price2=0,$type=0)
    {
        if($type==0)
        {
            $product=ProductDetail::where('quantity','>','0')->simplePaginate(12);
        }
        if($type==1)
        {
            $product=ProductDetail::where('price','>',$price1)->where('price','<',$price2)->where('quantity','>','0')
            ->orderBy('price')->simplePaginate(2);
        }
        if($type==2)
        {
            $product=ProductDetail::where('price','>',$price1)->where('price','<',$price2)->where('quantity','>','0')
            ->orderBy('price','desc')->simplePaginate(12);
        }
        if($type==3)
        {
            $product= ProductDetail::where('price','>',$price1)->where('price','<',$price2)->where('quantity','>','0')
            ->simplePaginate(12);
        }
        return $product;
    }
    public static function productDiscount($discount)
    {
        $product=ProductDetail::where('discount','>',$discount)->simplePaginate(12);
        return $product;
    }
    public  static function productIddetail($Id,$quantity=0)
    {
        if($quantity==0)
            $product=ProductDetail::where('Id',$Id)->where('quantity','>','0')->get();
        if($quantity==1)
            $product=ProductDetail::where('Id',$id)->get();

        return $product;
    }
    public static function likeProducts($value)
    {
        $products=ProductDetail::where('product_name','like','%'.$value.'%')->orWhere('company_name', 'like', '%'.$value.'%')
        ->orWhere('description', 'like', '%'.$value.'%')->get();
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
    public static function productQuantity($id)
    {
        $quantity=ProductDetail::where('Id',$id)->get(['quantity']);
        return $quantity;
    }
    public static function updateProduct($id,$data)
    {
        ProductDetail::where('Id',$id)->update($data);
    }    
    protected $fillable=['description','product_name','company_name','offer','discount','price','quantity',
    'merchant_phone_number','image_path'];
    public $timestamps=false;
}
