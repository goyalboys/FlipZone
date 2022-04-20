
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
 
 var slider1 = document.getElementById("price1");
  var output1 = document.getElementById("output1");
  var slider2 = document.getElementById("price2");
  var output2 = document.getElementById("output2");
  output1.innerHTML = slider1.value;
  $("#price1").change(function(){
    output1.innerHTML = this.value;
    $.ajax({
        url:"filter_apply_price",
        type:"get",
        data:{'price1':this.value,'price2':slider2.value},
        //data:'_token = <?php echo csrf_token() ?>',
        success:function(data)
        {
            console.log(data.products);
            var count=0;
            var forl = document.getElementById("foreach");
            forl.innerHTML="";
            temp="";
            
            $.each(data.products.data,function(key,item){
                if(count%3==0)
                //$('#foreach').append('<div class="row p-4">')
                temp+='<div class="row p-4">';

                temp+='<div class="col-sm-4 mt-4">\
                <a href="product/'+item.Id+'" style="color:black;">\
                    <div class="box-design">\
                        <img src="../storage/'+item.image_path+'" height="160px" width="100%" style="position: relative;" id="image-register""> \
                        '+item.company_name +item.product_name+'<br>\
                        <hr>\
                        price:<del>'+item.price+  '</del>  '+(item.price-(item.price*item.discount/100))+'<br>\
                    </div></a>\
                </div>'                    
                
                if(count%3==2)
                    temp+='</div>';
                count++
               
            })
            if(count%3!=2)
                temp+='</div>';
            forl.innerHTML=temp;
            console.log(temp);
        }})
  })


  output2.innerHTML = slider2.value;
  
  $("#price2").change(function(){
    output2.innerHTML = this.value;
    $.ajax({
        url:"filter_apply_price",
        type:"get",
        data:{'price2':this.value,'price1':slider1.value},
        dataType:'json',
        //data:'_token = <?php echo csrf_token() ?>',
        success:function(data)
        {
            console.log(data.products);
            var count=0;
            var forl = document.getElementById("foreach");
            forl.innerHTML="";
            temp="";
            $.each(data.products.data,function(key,item){
                if(count%3==0)
                //$('#foreach').append('<div class="row p-4">')
                temp+='<div class="row p-4">';

                temp+='<div class="col-sm-4 mt-4">\
                <a href="product/'+item.Id+'" style="color:black;">\
                    <div class="box-design">\
                        <img src="../storage/'+item.image_path+'" height="160px" width="100%" style="position: relative;" id="image-register""> \
                        '+item.company_name +item.product_name+'<br>\
                        <hr>\
                        price:<del>'+item.price+  '</del>  '+(item.price-(item.price*item.discount/100))+'<br>\
                        </div></a>\
                </div>';                    
                
                if(count%3==2)
                    temp+='</div>';
                count++;
               
            })
            if(count%3!=2)
                temp+='</div>';
            forl.innerHTML=temp;
            console.log(temp);


        }})
  })

  $("#lowtohigh").on('click', function() {
    var slider1 = document.getElementById("price1");
    var slider2 = document.getElementById("price2");

    $.ajax({
        url:"sortBylowtohigh",
        type:"get",
        data:{'price2':slider2.value,'price1':slider1.value},
        //dataType:'json',
        //data:'_token = <?php echo csrf_token() ?>',
        success:function(data)
        {
            console.log(data);

            //$('#product_data').html(data);
          console.log(data.products);
            var count=0;
            var forl = document.getElementById("foreach");
            forl.innerHTML="";
            temp="";
            $.each(data.products.data,function(key,item){
                if(count%3==0)
                //$('#foreach').append('<div class="row p-4">')
                temp+='<div class="row p-4">';

                temp+='<div class="col-sm-4 mt-4">\
                <a href="product/'+item.Id+'" style="color:black;">\
                    <div class="box-design">\
                        <img src="../storage/'+item.image_path+'" height="160px" width="100%" style="position: relative;" id="image-register""> \
                        '+item.company_name +item.product_name+'<br>\
                        <hr>\
                        price:<del>'+item.price+  '</del>  '+(item.price-(item.price*item.discount/100))+'<br>\
                        </div></a>\
                </div>';                    
                
                if(count%3==2)
                    temp+='</div>';
                count++;
               
            })
            if(count%3!=2)
                temp+='</div>';
            forl.innerHTML=temp;
            console.log(temp);
            //var fo = document.getElementById("product-links");
            //fo.innerHTML="<?php echo data.products.links(); ?>";





        }})
  });

  $("#hightolow").on('click', function() {
    var slider1 = document.getElementById("price1");
    var slider2 = document.getElementById("price2");
    console.log("hi");
    $.ajax({
        url:"sortByhightolow",
        type:"get",
        data:{'price2':slider2.value,'price1':slider1.value},
        dataType:'json',
        //data:'_token = <?php echo csrf_token() ?>',
        success:function(data)
        {
            console.log(data.products);
            var count=0;
            var forl = document.getElementById("foreach");
            forl.innerHTML="";
            temp="";
            $.each(data.products.data,function(key,item){
                if(count%3==0)
                //$('#foreach').append('<div class="row p-4">')
                temp+='<div class="row p-4">';

                temp+='<div class="col-sm-4 mt-4">\
                <a href="product/'+item.Id+'" style="color:black;">\
                    <div class="box-design">\
                        <img src="../storage/'+item.image_path+'" height="160px" width="100%" style="position: relative;" id="image-register""> \
                        '+item.company_name +item.product_name+'<br>\
                        <hr>\
                        price:<del>'+item.price+  '</del>  '+(item.price-(item.price*item.discount/100))+'<br>\
                    </div></a>\
                </div>';                    
                
                if(count%3==2)
                    temp+='</div>';
                count++;
               
            })
            if(count%3!=2)
                temp+='</div>';
            forl.innerHTML=temp;
            console.log(temp);
            

        }})
  });

  $("#rating").on('click', function() {
    var slider1 = document.getElementById("price1");
    var slider2 = document.getElementById("price2");

    $.ajax({
        url:"sortByrating",
        type:"post",
        data:{'price2':slider2.value,'price1':slider1.value},
        dataType:'json',
        //data:'_token = <?php echo csrf_token() ?>',
        success:function(data)
        {
            console.log(data);
            
        }})

  });



  $(".discount").on('click', function() {
    var value=$('input[name="discount"]:checked').val();
    $.ajax({
        url:"discount",
        type:"get",
        data:{'discount':value.split('%')[0]},
        dataType:'json',
        //data:'_token = <?php echo csrf_token() ?>',
        success:function(data)
        {
            
            console.log(data.products);
            var count=0;
            var forl = document.getElementById("foreach");
            forl.innerHTML="";
            temp="";
            $.each(data.products.data,function(key,item){
                if(count%3==0)
                //$('#foreach').append('<div class="row p-4">')
                temp+='<div class="row p-4">';

                temp+='<div class="col-sm-4 mt-4">\
                <a href="product/'+item.Id+'" style="color:black;">\
                    <div class="box-design">\
                        <img src="../storage/'+item.image_path+'" height="160px" width="100%" style="position: relative;" id="image-register""> \
                        '+item.company_name +item.product_name+'<br>\
                        <hr>\
                        price:<del>'+item.price+  '</del>  '+(item.price-(item.price*item.discount/100))+'<br>\
                    </div></a>\
                </div>';                    
                
                if(count%3==2)
                    temp+='</div>';
                count++;
               
            })
            if(count%3!=2)
                temp+='</div>';
            forl.innerHTML=temp;
            console.log(temp);
            
        }})

    console.log("hi");
    
  });