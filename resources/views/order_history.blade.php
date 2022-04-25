


@extends('navbar')
@section('mytitle', 'Order History ')
@section('content')
    <div class="billing-us">
    Order History
    </div>
    <div class="cart-history">
    @foreach($orders as $order)
            <div class="row">
                <div class="col-sm-4">
                    <img src="../storage/{{$order->image_path}}" height='160px' width='40%' style="position: relative;" id="image-register"><br>
                </div> 
                <div class="col-sm-4">
                    Order Id : {{$order->orderId}}<br>
                    <h2>shipping Address:<br></h2>
                    Phone Number: {{$order->phone_no}}<br>
                    Address: {{$order->address}} 
                    {{$order->pincode}}
                    {{$order->city}}
                    {{$order->state}}<br>
                    <h4>Price:{{$order->price-($order->price*$order->discount/100)}}<br></h4>
                </div>
                <div class="col-sm-4">
                    <div style="text-align:center;">
                        <a href="cancel_order/{{$order->orderId}}"> 

                            <button type="button" class="btn btn-primary"  >
                                Cancel Order
                            </button>
                        </a>
                    </div>
                    
                </div>
            </div>
            <hr>
        @endforeach
    </div>
    <div style=" position:fixed; width:100%; height:50px; bottom:0;   background-color:black;">
        <div style="text-align:center; color:white;padding-top:10px;">
            CopyRight@FlipZone
        </div>
    </div>
@endsection
