<?php
$this->title = 'Корзина';
$all_sum=0;
?>
<div class="cart-default-index">
    <div class="wrap-figura-block" style="margin-top: 20px;">
        <div class="left-figura"></div>
        <div class="center-figura"><h1>Корзина</h1></div>
        <div class="right-figura"></div>
    </div>
    <div class="line-figura"></div>
    <?php if(count($goods)>0):?>
    <form action="/cart/issue"  method="post" enctype="multipart/form-data" id="cart-form">
        <table  class="cart-table-goods">
            <tr>
                <th></th>
                <th class="cart-name">Наименование</th>
                <th>Цена за ед.</th>
                <th>Количество</th>
                <th >Стоимость</th>
                <th></th>
            </tr>
        <?foreach($goods as $g):?>
            <?php $all_sum = $all_sum + $g['price']*$g['count'];?>
    
            <tr class="table-item-goods" data-goods-id="<?=$g['id']?>" id="row_goods_<?=$g['id']?>">
                <input type="hidden" name=arr_goods_id[] value="<?=$g['id']?>">
                <td class="cart-img">
                    <?if(!empty($g['imgname'])):?>
                        <a href="/<?=$g['imgname']?>" data-lightbox="image-group" data-title="<?=$g['desc']?>"><img src="/<?=$g['imgname']?>" alt="" style="width:50px;"/></a>
                    <?else:?>
                        <img src="/image/noimg.jpg" alt="" style="width:50px;"/>
                    <?endif;?>
                </td>
                <td class="cart-name">
                    <a title="<?=$g['name']?>" href="/product/<?=$g['cat_id']?>/<?=$g['id']?>"><?=$g['name']?></a>
                </td>
                <td class="cart-price" data-price="<?=$g['price']?>">
                     <span class="cart-price-val"><?=$g['price']?></span><span class="glyphicon glyphicon-ruble"></span>
                </td>
                <td class="cart-count">
                    <div class="cart-count-block">
                        <a href="#" class="cart_down">-</a>
                        <input class="input_count" value="<?=$g['count']?>" name=arr_goods_count[]>    
                        <a href="#" class="cart_up">+</a>
                    </div>                            
                </td>
                <td class="cart-sum">                            
                     <span class="cart-sum-val"><?=$g['price']*$g['count']?></span><span class="glyphicon glyphicon-ruble"></span>                    
                </td>
                <td class="cart-del">                                
                    <button  type="button" name="del" class="btn cart-del">x</button>
                </td>
            </tr>
        <?endforeach;?>
        <tr>
            <td colspan="6" class="cart_itogo">
                <div class="wrap-all-sum">
                <div  class="all-sum">Итого к оплате: <span id="all-sum-val"><?=$all_sum?></span><span class="glyphicon glyphicon-ruble"></span></div>
                <a href="/cart/issue"><input type="button" name="btn btn-orange cart_sbm" class="cart_submit" value="Оформить заказ"></a>
            </td>
        </tr>
        </table>
    </form>
   <?php else:?>
        Ваша корзина пуста
   <?php endif;?>  
</div>
<div class="clearfix"></div>
