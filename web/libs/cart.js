$('document').ready(function()
{  
    
   $(document).on("submit","#cart-form", function(){
        calcSum();
        return false;
   });

   $(document).on("click",".cart-del", function(){
       var goods_id=$(this).parent().parent().attr('data-goods-id');
       $('#row_goods_'+goods_id).remove();
      
       $.ajax({                
                type:"POST",
                url: "/cart/del",
                data: {goods_id:goods_id},
                cache: false,  
                success: function(data){
                    var response = JSON.parse(data);
                    if(typeof response.errors !="undefined"){
                       // есть ошибки
                       //alert("Невозможно удалить товар")
                       
                    }
                    if(typeof response.ok !="undefined"){
                       // положительный ответ
                       // alert("Товар удален из карзины")
                       $('#row_goods_'+goods_id).remove();
                       calcSum();
                    }
                }
           });
               //alert("Удаляем ", $(this).parent().parent().attr('data-goods-id'));
        //console.log($(this).parent().parent().attr('data-goods-id'));
        return false;
        
   });


   $(document).on("click",".cart_up", function(){
      // event.preventDefault();
       //return false;
        //var cur_count=parseInt($(this).parent().find("input").attr('value'));
        var cur_count=parseInt($(this).parent().find("input").val());
        //var cur_price = parseInt($(this).parent().parent().parent().find(".cart-price-val").html());              
        cur_count=cur_count+1;
        //$(this).parent().find("input").attr('value', cur_count) ;
        $(this).parent().find("input").val(cur_count) ;
        $(this).parent().find("input").change();
        return false;
   });


   $(document).on("click",".cart_down", function(){ 
       // return false;
       // var cur_count=parseInt($(this).parent().find("input").attr('value'));
        var cur_count=parseInt($(this).parent().find("input").val());
        if(cur_count>0)
              cur_count--;        
        //$(this).parent().find("input").attr('value', cur_count) ;
        $(this).parent().find("input").val(cur_count) ;
        $(this).parent().find("input").change();
        return false;
   });


   // пересчет только для страницы корзины
    $(document).on("change","#cart-form .input_count", function(Evant){ 
     
      //console.log(Evant);
       //alert("Пересчитываем")
       var cur_count=parseInt($(this).val());  
       // alert("поменяли" + $(this));
        console.log($(this).val());
       var cur_price = parseInt($(this).parent().parent().parent().find(".cart-price-val").html()); 
       var goods_id=$(this).parent().parent().parent().attr('data-goods-id');
       $(this).parent().parent().parent().find(".cart-sum-val").html(cur_count*cur_price);
       calcSum();
       // меняем содержимое козины в сессии
       $.ajax({                
             type:"POST",
             url: "/cart/bay",
             data: {goods_id:goods_id, cnt:cur_count},
             cache: false,  
             success: function(data){
                 var response = JSON.parse(data);
                 if(typeof response.errors !="undefined"){
                    // есть ошибки                  
                 }
                 if(typeof response.ok !="undefined"){
                    // положительный ответ
                     //alert("Товар добавлен в корзину")
                    $('.cart-widget-wrap').html(response.cart_widget);

                 }
             }
        });	
     
    });


    function calcSum(){
         var sum_all = 0;
        $.each($('#cart-form').find("input.input_count"), function(key, value) {
          var cur_price1 = parseInt($(value).parent().parent().parent().find(".cart-price-val").html());
          var cur_count1 =  parseInt($(value).val());
	  //alert("количество" + ': ' + $(value).val());
	  //alert("цена" + ': ' + );
         
          sum_all = sum_all + cur_count1 * cur_price1;
           // alert("цена" + ': ' + sum_all);
	      });
        $('#all-sum-val').html(sum_all);
    }

    $(document).on("click",".cart-button-bay", function(){
        //alert("Купить товар");
        var goods_id=$(this).attr('value');

         var cur_count=parseInt($(this).parent().find("input").val());
         var cur_button =$(this);
        //alert($(this).val());
        // console.log($(this).attr('value'));
        //return;
        ///////////////////////
        $.ajax({                
                type:"POST",
                url: "/cart/bay",
                data: {goods_id:goods_id, cnt: cur_count},
                cache: false,  
                success: function(data){
                    var response = JSON.parse(data);
                    if(typeof response.errors !="undefined"){
                       // есть ошибки
                       alert("Данный товар невозможно купить")
                       
                    }
                    if(typeof response.ok !="undefined"){
                       // товар добавлен в корзину
                       //alert("Товар добавлен в корзину")
                       $('.cart-widget-wrap').html(response.cart_widget);
                       cur_button.html('В корзине');  
                       cur_button.addClass('in-cart');
                       cur_button.parent().find('.go-to-cart').html('<a href="/cart">Оформить заказ</a>')
                    }
                }
           });			        
        ///////////////////////
    });
});