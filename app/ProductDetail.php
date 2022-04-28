<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class ProductDetail extends Model
{
    protected $fillable=[
        'description',
        'product_name',
        'company_name',
        'offer',
        'discount',
        'price',
        'quantity',
        'merchant_phone_number',
        'image_path'
    ];
    public $timestamps=false;

    public static function insertProduct($data)
    {
       return  self::Create($data);
    }
    public static function showLimitedProduct($data)
    {
        $product=self::where('quantity','>','0')->simplePaginate($data);
        return $product;
    }
    public static function allProducts($price1=0,$price2=0,$type=0)
    {
        $product=new ProductDetail;
        $product=$product->where('quantity','>','0');
        //dd($product);
        if($type!=0)
        {
            $product=$product->where('price','>',$price1)->where('price','<',$price2);
        }
        switch($type)
        {
            case 1:
                $product=$product->orderBy('price');
                break;
            case 2:
                $product=$product->orderBy('price','desc');
                break;
        }
        return $product->simplePaginate(12);
    }
    public static function productDiscount($discount)
    {
        $product=self::where('discount','>=',$discount)->simplePaginate(12);
        return $product;
    }
    public  static function productIddetail($Id,$quantity=0)
    {
        if(!empty(self::find($Id)))
        {
            if($quantity==0)
                $product=self::where('Id',$Id)->where('quantity','>','0')->get();
            if($quantity==1)
                $product=self::where('Id',$Id)->get();
            return $product;
        }

        //throw new Exception("Error Processing Request");
            
    }
    public static function likeProducts($value)
    {
        $products=self::where(
            function($query) use($value)
            {   $query->where('product_name','like','%'.$value.'%')
                ->orWhere('company_name', 'like', '%'.$value.'%')
                ->orWhere('description', 'like', '%'.$value.'%');
            })
                ->where('quantity','>','0')->limit(5)->get();
        return $products;
    }

    public static function merchantProducts($merchantPhoneNumber)
    {
        $products=self::where('merchant_phone_number',session('active_user'))->simplePaginate(12);
        return $products;
    }
    public static function merchantProductIddetail($id)
    {
        $products=self::where('Id',$id)->simplePaginate(12);
        return $products;
    }
    public static function productImagepath($id)
    {
        $imagePath=self::where('Id', $id)->get(['image_path'])[0]->imagePath;
        return $imagePath;
    }    
    public static function deleteProduct($id)
    {
        return self::where('Id', $id)->delete();
        
    }
    public static function productQuantity($id)
    {
        $quantity=self::where('Id',$id)->get(['quantity']);
        return $quantity;
    }
    public static function updateProduct($id,$data)
    {
        return self::where('Id',$id)->update($data);
    }  
    public static function showProductspaginate($data)
    {
        $products=self::skip($data['start'])->take($data['end'])->orderBy('product_name')->get();
        return $products;
    }  
    
}