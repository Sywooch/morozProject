$('document').ready(function(){
    
   $(document).on("submit","#cart-form", function(){
        calcSum();
        return false;
   });


   $(document).on("click",".cart-del", function(){
       var goods_id = $(this).parent().parent().attr('data-goods-id');


      
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
                    $('#row_goods_' + goods_id).remove();
                    $('.cart-widget-wrap').html(response.cart_widget);
                    calcSum();
                    var kol = $('.table-item-goods').length;
                    if(kol==0){
                        $("#cart-form").remove();
                        $(".cart-default-index").append("<p>Ваша корзина пуста</p>");
                    }
                }
            }
       });
       return false;
        
   });


   $(document).on("click",".cart_up", function(){
        var cur_count = parseInt($(this).parent().find("input").val());
        if(cur_count<=0) {
            cur_count = 1;
        }
        cur_count = cur_count + 1;
        $(this).parent().find("input").val(cur_count) ;
        $(this).parent().find("input").change();
        return false;
   });


    $(document).on("click",".cart_down", function(){
        var cur_count=parseInt($(this).parent().find("input").val());
        if(cur_count > 0){
           cur_count--;
        }
        if(cur_count<=0) {
            cur_count = 1;
        }

        $(this).parent().find("input").val(cur_count) ;
        $(this).parent().find("input").change();
        return false;
    });


    // пересчет только для страницы корзины
    $(document).on("change","#cart-form .input_count", function(Evant){
        var cur_count = parseInt($(this).val());
        if(cur_count<=0) {
            cur_count = 1;
            $(this).val(cur_count);
        }
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
            sum_all = sum_all + cur_count1 * cur_price1;
        });
        $('#all-sum-val').html(sum_all);
    }

    $(document).on("click",".cart-button-bay", function(){
        var goods_id = $(this).attr('value');
        var cur_count = parseInt($(this).parent().find("input").val());
        var cur_button = $(this);
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
                    $('.cart-widget-wrap').html(response.cart_widget);
                    cur_button.html('В корзине');
                    cur_button.addClass('in-cart');
                    cur_button.parent().find('.go-to-cart').html('<a href="/cart">Оформить заказ</a>')
                }
            }
        });
    });
});