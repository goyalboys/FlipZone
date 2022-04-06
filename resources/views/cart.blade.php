
@extends('navbar')
@section('content')
    <div class="billing-us">
    Cart Items
    </div>
    <div class="cart-history">
        @if(count($product_cart))
            @foreach($product_cart as $product)
                <div class="row">
                    <div class="col-sm-4">
                        <img src="../storage/{{$product->image_path}}" height='160px' width='40%' style="position: relative;" id="image-register"><br>
                    </div> 
                    <div class="col-sm-4">
                        Name:{{$product->product_name}}<br>
                        Company:{{$product->company_name}}<br>
                        Description:{{$product->description}}<br>

                        price:<del>{{$product->price}}</del>
                        {{$product->price-($product->price*$product->discount/100)}}<br>
                        Discount:{{$product->discount}}%<br>
                        Quantity:{{$product->quantity}}<br>
                        Offer:{{$product->offer}}<br>
                        {{$product->Id}}
                    </div>
                    <div class="col-sm-4">
                    <div style="text-align:center;">
                        <a href="removefromcart/{{$product->Id}}"> 

                            <button type="button" class="btn btn-primary"  >
                                Remove
                            </button>
                        </a>
                </div>
            </div>
                </div>

                <hr>
            @endforeach
        <div style="text-align:center;"><a href="../checkoutcart"><button type="button" class="btn btn-primary"  > Buy Now</button></a></div>
        @endif
    </div>
    
    <div style=" position:fixed; width:100%; height:50px; bottom:0; background-color:black;">
        <div style="text-align:center; color:white;padding-top:10px;">
            CopyRight@FlipZone
        </div>
    </div>
@endsection