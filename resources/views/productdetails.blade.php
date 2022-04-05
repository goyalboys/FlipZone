@extends('navbar')
@section('content')
<div  id=container1>
    <div  id="column1">
        <div class="side_container">
            <h2 style="color:white;">services</h2><hr>
            <a href="add_product_details" aria-current="true">Add product</a><hr>
            <a href="#">Product Details</a><hr>
            <a href="order_receive"> Order Receive</a><hr>

        </div>
    </div>
    <div id="column2">
        
    @foreach($products as $product)
            <div class="row">
                <div class="col-sm-4">
                    <img src="../storage/{{$product->image_path}}" height='160px' width='40%' style="position: relative;" id="image-register"><br>
                </div> 
                <div class="col-sm-4">
                Product Name: {{$product->product_name}}<br>
                Company Name:{{$product->company_name}}<br>
                Description:{{$product->description}}<br>
                Offer:{{$product->offer}}<br>
                Discount:{{$product->discount}}<br>
                Quantity:{{$product->quantity}}<br>
                Price: {{$product->price}}<br>
                
                    <h4>Price:{{$product->price-($product->price*$product->discount/100)}}<br></h4>
                </div>
                <div class="col-sm-4">
                    <div style="text-align:center;">
                        <a href="../editproduct/{{$product->Id}}">  
                            <button type="button" class="btn btn-primary"  >
                                Edit Product
                            </button>
                        </a>
                    
                    </div>
                    <br>
                    <div style="text-align:center;">
                        <a href="../deleteproduct/{{$product->Id}}">  
                            <button type="delete" class="btn btn-primary">Delete</button>
                        </a>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach

  </div>
</div>
@endsection