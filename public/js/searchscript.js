$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function showResult(value)
{
    if (value.length==0) {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        return;
      }
      else{
        $.ajax({
            url:"searchproduct",
            type:"post",
            data:{'value':value},
            dataType:'json',
            //data:'_token = <?php echo csrf_token() ?>',
            success:function(data)
            {
                console.log(data);
                tmp='';
                $.each(data.item,function(key,item){
                    tmp+="<li><a href='product/"+item.Id+"'>";
                    tmp+=item.company_name+' '+item.product_name;
                    tmp+="</a></li>";
                    })

                    document.getElementById("livesearch").innerHTML=tmp;

                //console.log(data.item);
                
            }})

      }
}
