@extends('navbar')
@section('mytitle', 'Products')
@section('content')
    <div class="filter-row">
        <div class="column-filter">
            <div class="filters">
                <h2 style="text-align:center;">Filters</h2>
                
                <b>Price:</b>
                <br>
                <div class="price-slider">
                    <input class="form-range" value="100" min="100" max="2200" step="1" type="range" id="price1">
                    <input class="form-range" min="100" value="2200" max="2200" step="1" type="range" id="price2">
                </div>
                <div>
                    <span id="output1"style=" float:left;"></span>
                    <span id="output2" style=" float:right;"></span>
                </div>
                <br>
                <hr>
                <b>Company:</b>
                <br>
                @foreach($companies as $company)
                <input type="checkbox" name={{$company}} value={{$company}}>{{$company}}<br>
                @endforeach
                <hr>
                <b>Rating:</b>
                <br>
                <input type="radio" name="rating" value="4" > 4⭐& above<br>
                <input type="radio" name="rating" value="3" > 3⭐& above<br>
                <input type="radio" name="rating" value="2" > 2⭐& above<br>
                <input type="radio" name="rating" value="1" > 1⭐& above<br>
                <br>
                <hr>
                <b>Offer:</b>
                <br>
                @foreach($offers as $offer)
                    <input type="checkbox" name={{$offer}} value={{$offer}}>{{$offer}}<br>
                @endforeach
                <hr>
                <b>size:</b><br>
                <input type="checkbox" name=""><br>
                <hr>
                <b>Discount:</b>
                <br>
                @foreach($discounts as $discount)
                    <input type="radio" name='discount'value={{$discount}}>{{$discount}} & above<br>
                @endforeach
                <br>
            </div>
        </div>
        <div class="column-products">
        
            <div class='our-product'>
                Products
            </div>
            <div class="top-bar" style="text-align:left;">        
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Sort by:
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><button class="dropdown-item" id="lowtohigh">Low to High</button></li>
                        <li><a class="dropdown-item" id="hightolow">High to Low</a></li>
                        <li><a class="dropdown-item"  id="rating">Rating</a></li>
                    </ul>
                </div>
            </div>
            <div style="display:none">
                {{$count=0}}
            </div>
            <br>
            <hr>
            <div id="foreach">                
                @foreach($products as $product)
                    @if($count%3==0)
                        <div class="row p-4">
                    @endif
                    <div class="col-sm-4 mt-4">
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
                    @if($count%3==2)
                        </div>
                    @endif 

                    <div style="display:none">
                        {{$count++}}
                    </div>
                @endforeach
                @if($count%3!=2)
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</div>

 <div class="d-flex justify-content-center">
 {{$products->links()}}
</div>
<br>
<div style="width:100%; height:50px;  background-color:black;">
    <div style="text-align:center; color:white;padding-top:10px;">
        CopyRight@FlipZone
    </div>
</div>
<script src="{{ asset('js/script_product.js') }}"></script>
@endsection