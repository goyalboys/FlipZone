@extends('navbar')
@section('mytitle', 'Product')
@section('content')
<div class="row">
    <div class="col-sm-6 p-6">
        <div class="box-content">

            <img src="../../storage/{{$product[0]->image_path}}" height='260px' width='100%' style="position: relative;" id="image-register""> 
            
           
        </div>
    </div>
    <div class="col-sm-6">
        <div class="product-content">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <h1>{{$product[0]->company_name}}
            {{$product[0]->product_name}}<br></h1>
            <hr>
            
            <h3><b>Price: </b><del>{{$product[0]->price}}</del><br></h3>
            <i>Discount: {{$product[0]->discount}}%</i><br>
            <h3>Price: {{$product[0]->price-($product[0]->price*$product[0]->discount/100)}}<br>
            <B>Description:</B> {{$product[0]->description}}<br>
            <b>Offer: </b>{{$product[0]->offer}}<br>
            <b>Review:</b> {{$product[0]->Review}}<br>
            <b>Quantity: </b>{{$product[0]->quantity}}<br>
            </h3>
        </div>
        <div style="text-align:center;"><a href="../checkout/{{$product[0]->Id}}"><button type="button" class="btn btn-primary"  > Buy Now</button></a></div>
        <div ><a href="../cart/{{$product[0]->Id}}"><button type="button" class="btn btn-primary"  > Add to cart</button></a></div>
    </div>

</div>


@endsection