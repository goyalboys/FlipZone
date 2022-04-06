@extends('navbar')
@section('content')
<div  id=container1>
    <div  id="column1">
        <div class="side_container">
            <h2 style="color:white;">services</h2><hr>
            <a href="add_product_details" aria-current="true">Add product</a><hr>
            <a href="productdetails">Product Details</a><hr>
            <a href="order_receive">Orders Recieved</a><hr>
        </div>
    </div>
    <div id="column2">
            @foreach($problems as $problem)
            <div class="row">
                <div class="col-sm-4">
                    <b>Name:</b>{{$problem->name}}<br>
                    <b>Phone:</b>{{$problem->phone}}<br>
                    <b>Subject:</b>{{$problem->subject}}<br>
                    <b>Problem:</b>{{$problem->problem}}<br>
                </div>
            <div class="col-sm-4">
                <a href="../resolved/{{$problem->contactId}}"><button type="button" class="btn btn-primary"  > Resolved</button></a>
            </div>
        </div>
        <hr>
        @endforeach
  </div>
</div>
@endsection