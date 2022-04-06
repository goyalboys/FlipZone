@extends('navbar')
@section('content')
<div  id=container1>
    <div  id="column1">
        <div class="side_container">
            <h2 style="color:white;">services</h2><hr>
            <a href="add_product_details" aria-current="true">Add product</a><hr>
            <a href="productdetails">Product Details</a><hr>
            <a href="order_receive"> order received</a><hr>
            <a href="#">Past Orders</a><hr>



        </div>
    </div>
    <div id="column2">
    @foreach($products as $product)
            <div class="row">
                <div class="col-sm-4">
                    <img src="../storage/{{$product->image_path}}" height='160px' width='40%' style="position: relative;" id="image-register"><br>
                </div> 
                <div class="col-sm-4">
                
                    Product Id:{{$product->product_id}}
                    <h2>Shipping Address:<br></h2>
                    Phone Number: {{$product->phone_no}}<br>
                    Address: {{$product->address}} 
                    {{$product->pincode}}
                    {{$product->city}}
                    {{$product->state}}<br>
                    <h4>price:{{$product->price-($product->price*$product->discount/100)}}<br></h4>
                    Customer Phone:{{$product->customer_phone}}<br>
                    Order Date:{{$product->added_on}}

                </div>
                <!--<div class="col-sm-4">
                    <div style="text-align:center;">
                        <a href="#"> 

                            <button type="button" class="btn btn-primary"  >
                                Delivered
                            </button>
                        </a>
                    
                    </div>
                    </div>-->
            </div>
            <hr>
        @endforeach

  </div>
</div>
@endsection