@extends('navbar')
@section('content')

<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">
        <div class="mySlides fades">
            <img src="../images/img3.jpg" style="width:100%; height:350px">
        </div>

        <div class="mySlides fades">
            <img src="../images/img2.jpg" style="width:100%;height:350px">
        </div>

        <div class="mySlides fades">
            <img src="../images/img1.jpg" style="width:100%;height:350px">
        </div>

        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
    </div>
</div>

<br>

<div class='shop-us'>
    Why Shop With Us
</div>

    <div class="row p-4">
        <div class="col-sm-4 mt-4 ">
            <div class="shop-why">Fast Shipping </div>
        </div>
        <div class="col-sm-4 mt-4">
            <div class="shop-why">Free Dilvery</div>
        </div>
        <div class="col-sm-4 mt-4">
            <div class="shop-why">Best Quality</div>
        </div>
    </div>      
<div class='our-product'>
    Our Products
</div>
<div style="display:none">
{{$count=0}}
</div>
@foreach($products as $product)
    @if($count%4==0)
    <div class="row p-4">
    @endif
    <div class="col-sm-3 mt-4">
        <a href="product/{{$product->Id}}" style="color:black;">
            <div class="box-design">
                <img src="../storage/{{$product->image_path}}" height='160px' width='100%' style="position: relative;" id="image-register""> 
                {{$product->company_name}}
                {{$product->product_name}}<br>
                <hr>
                price:<del>{{$product->price}}</del>
                {{$product->price-($product->price*$product->discount/100)}}<br>
            </div>
        </a>
    </div>
    @if($count%4==3)
        </div>
    @endif 

    <div style="display:none">
        {{$count++}}
    </div>

@endforeach

@if($count%3!=2)
        </div>
 @endif
 
  <br>

    <br>
<div style="width:100%; height:150px;  background-color:rgb(100, 93, 93);">

</div>
<div style="width:100%; height:50px;  background-color:black;">
    <div style="text-align:center; color:white;padding-top:10px;">
        CopyRight@FlipZone
    </div>
</div>

 
<script src="{{ asset('js/script.js') }}"></script>
@endsection