@extends('navbar')
@section('content')
<div  id=container1>
    <div  id="column1">
        <div class="side_container">
            <h2 style="color:white;">services</h2><hr>
            <a href="#" aria-current="true">Add product</a><hr>
            <a href="#">Product Details</a><hr>
        </div>
    </div>
    <div id="column2">
        <form class="row g-3" name="myForm" method="post" action='/add_product' enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-md-6">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" name="product_name" value="{{ old('product_name') }}" autocomplete="off">
                @if($errors->has('product_name'))
                    <div id='warning'>{{ $errors->first('product_name') }}</div>
                @endif
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">company Name</label>
                <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" autocomplete="off" class="login__input">
                    @if($errors->has('company_name'))
                        <div id='warning'>{{ $errors->first('company_name') }}</div>
                    @endif
            </div>
            <div class="col-md-6">
                <label for="inputState" class="form-label">Offer</label>
                <select id="inputState" class="form-select" name="offer" value="{{ old('offer') }}" autocomplete="off" >
                <option selected>Summer Sale</option>
                <option>Winter Sale</option>
                <option>At Low Cost Emi</option>
                </select>
                @if($errors->has('offer'))
                    <div id='warning'>{{ $errors->first('offer') }}</div>
                @endif
            </div>
            <div class="col-md-6">
                <label for="inputZip" class="form-label">Price</label>
                <input type="text" class="form-control" name="price" value="{{ old('price') }}" autocomplete="off" class="login__input">
                @if($errors->has('price'))
                        <div id='warning'>{{ $errors->first('price') }}</div>
                @endif
            </div>
            <div class="col-md-4">
                <label for="inputZip" class="form-label">Quantity</label>
                <input type="text" name="quantity" class="form-control" value="{{ old('quantity') }}" autocomplete="off" class="login__input">
                @if($errors->has('quantity'))
                    <div id='warning'>{{ $errors->first('quantity') }}</div>
                @endif
            </div>
            <div class="col-md-4">
                <label for="inputZip" class="form-label">Image</label>
                <input type="file" class="form-control" name="image" value="{{ old('image') }}" autocomplete="off" class="login__input" accept="image/*">
                @if($errors->has('image'))
                        <div id='warning'>{{ $errors->first('image') }}</div>
                @endif
            </div>
            <div class="col-md-4">
                <label class="form-label">Discount</label>
                <input class="form-control" type="text" name="discount" value="{{ old('discount') }}" autocomplete="off" class="login__input">
                @if($errors->has('discount'))
                        <div id='warning'>{{ $errors->first('discount') }}</div>
                    @endif
            </div>
            <div class="col-md-12">
                <label class="form-label">Description</label><br>
                <textarea  class="form-control" name="description" value="{{ old('description') }}" autocomplete="off"></textarea>
                @if($errors->has('description'))
                        <div id='warning'>{{ $errors->first('description') }}</div>
                    @endif
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
        </form>
  </div>
</div>
@endsection
    