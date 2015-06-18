<?if(!$no_wrap):?>
<div class="cart-widget-wrap">
<?endif;?>
    <a href="/cart" class="lnl-cart"><span class="img-cart"></span>КОРЗИНА (<?=count($products)?>)</a>
    <div class="inner-cart-widget">
        <?if(count($goods)>0):?>
            <table class="tbl-widget-cart">
                <?foreach($goods as $g):?>
                    <tr>
                        <td>
                            <?if(!empty($g['imgname'])):?>
                                <a href="/product/<?=$g['cat_id']?>/<?=$g['id']?>"><img src="/<?=$g['imgname']?>" alt="" style="width: 50px;"/></a>
                            <?else:?>
                                <!-- заглушка-->
                                <a href="/product/<?=$g['cat_id']?>/<?=$g['id']?>"><img src="/image/noimg.jpg" alt="" style="width: 50px;"/></a>
                            <?endif;?>
                        </td>
                        <td>
                            <a href="/product/<?=$g['cat_id']?>/<?=$g['id']?>" class="lnk-name"><?=$g['name'];?></a>
                        </td>
                        <td style="width: 50px">
                            <?=$products[$g['id']]['count']?> шт
                        </td>
                    </tr>
                <?endforeach;?>
            </table>
            <a href="/cart/issue" class="btn-widget-issue">Оформить заказ</a>
        <?else:?>
            <p>Корзина пуста</p>
        <?endif;?>
    </div>
<?if(!$no_wrap):?>
</div>
<?endif;?>


<? $this->registerJs("
    $(function(){

        $(document).on('mouseover','.cart-widget-wrap>a',function(){
            $(this).css({
                'border-left':'1px solid #ef9a00',
                'border-top':'1px solid #ef9a00',
                'border-right':'1px solid #ef9a00',
                'background':'#fef7de',
            });
            $('.inner-cart-widget').show();
        });

        $(document).on('mouseout','.cart-widget-wrap>a',function(){
            $(this).css({
                'border-left':'1px solid #f9db6a',
                'border-top':'1px solid #f9db6a',
                'border-right':'1px solid #f9db6a',
                'background': 'transparent',
            });
            $('.inner-cart-widget').hide();
        });

        $(document).on('mouseover','.inner-cart-widget',function(){
            $('.cart-widget-wrap>a').css({
                'border-left':'1px solid #ef9a00',
                'border-top':'1px solid #ef9a00',
                'border-right':'1px solid #ef9a00',
                'background':'#fef7de',
            });
            $('.inner-cart-widget').show();
        });

        $(document).on('mouseout','.inner-cart-widget',function(){
            $('.cart-widget-wrap>a').css({
                'border-left':'1px solid #f9db6a',
                'border-top':'1px solid #f9db6a',
                'border-right':'1px solid #f9db6a',
                'background': 'transparent',
            });
            $('.inner-cart-widget').hide();
        });
    });
");?>