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

 <div id="product-links" class="d-flex justify-content-center">
 {{$products->links()}}
</div>