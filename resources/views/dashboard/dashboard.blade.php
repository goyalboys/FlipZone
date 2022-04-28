@extends('navbar')
@section('mytitle', 'merchant Dashboard')
@section('content')
<div  id=container1>
    <div  id="column1">
        <div class="side_container">
            <h2 style="color:white;">services</h2><hr>
            <a href="add_product" aria-current="true">Add product</a><hr>
            <a href="merchant_products">Product Details</a><hr>
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
                <button type="delete" class="btn btn-primary" 
                    onclick="event.preventDefault();document.getElementById('delete-form-{{ $problem->contactId }}').submit();">
                    Delete
                </button>
                <form id="delete-form-{{ $problem->contactId  }}" action="{{  route('delete_ticket', ['Id' => $problem->contactId ]) }}"
                    method="POST" style="display: none;">
                    {{method_field('Delete')}}
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        <hr>
        @endforeach
  </div>
</div>
@endsection