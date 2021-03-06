@extends('navbar')
@section('mytitle', 'Checkoutcart')
@section('content')
<div  id="container1">
    <div  id="column3">
        <div class="side_container">
            @foreach($products as $product)
                <div class="cartbuy-content">
                    <img src="../storage/{{$product->image_path}}" height='60px' width='10%' style="position: relative;" id="image-register""> 
                    {{$product->company_name}}
                    {{$product->product_name}}
                    Price: {{$product->price-($product->price*$product->discount/100)}}<br>
                </div>
            @endforeach
            Total Amount={{$totalprice}}
        </div>
    </div>
    <div id="column4">
            <div class="billing-us">Billing Details</div>
        <form class="row g-3" name="myForm" method="post" action='/order_products' enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="off">
                @if($errors->has('name'))
                    <div id='warning'>{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="{{ old('address') }}" autocomplete="off" class="login__input">
                    @if($errors->has('address'))
                        <div id='warning'>{{ $errors->first('address') }}</div>
                    @endif
            </div>
            
            <div class="col-md-6">
                <label for="inputZip" class="form-label">City</label>
                <input type="text" class="form-control" name="city" value="{{ old('city') }}" autocomplete="off" class="login__input">
                @if($errors->has('city'))
                        <div id='warning'>{{ $errors->first('city') }}</div>
                @endif
            </div>
            <div class="col-md-4">
                <label for="inputZip" class="form-label">Pincode</label>
                <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" autocomplete="off" class="login__input">
                @if($errors->has('pincode'))
                    <div id='warning'>{{ $errors->first('pincode') }}</div>
                @endif
            </div>
            <div class="col-md-4">
                <label for="inputZip" class="form-label">State</label>
                <input type="text" class="form-control" name="state" value="{{ old('state') }}" autocomplete="off" class="login__input">
                @if($errors->has('state'))
                        <div id='warning'>{{ $errors->first('state') }}</div>
                @endif
            </div>
            <div class="col-md-4">
                <label class="form-label">Phone Number</label>
                <input class="form-control" type="text" name="phone_number" value="{{ old('phone_number') }}" autocomplete="off" class="login__input">
                @if($errors->has('phone_number'))
                        <div id='warning'>{{ $errors->first('phone_number') }}</div>
                    @endif
            </div>
            <hr>
            <div class="billing-us">Payment Method</div>
            <div class="col-md-4">
                <label class="form-label">Cash On delivery</label>
                <input type="radio" name="cash_payment" value="cash_payment" autocomplete="off" checked >
                @if($errors->has('cash_payment'))
                        <div id='warning'>{{ $errors->first('cash_payment') }}</div>
                    @endif
            </div>
            <div class="col-12">
            <div style="text-align:center;"><button type="submit" class="btn btn-primary"  > Buy Now</button></div>
            </div>
        </form>
  </div>
</div>
@endsection
    