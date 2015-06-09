<div class="forum-tabs">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><div class="bglefttab"></div><a href="#home" >ХИТЫ ПРОДАЖ-45 наименований</a><div class="bgrigthtab"></div></li>
        <li><div class="bglefttab"></div><a href="#profile" >АКЦИИ И РАСПРОДАЖИ - скидки до 50%</a><div class="bgrigthtab"></div></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <div class="wrap-slider-home">
                <div class="slider4">
                    <?if(count($hit)>0):?>
                        <?foreach($hit as $h):?>
                            <div class="slide">
                                <div class="item-slider-home">
                                    <h1><a href="/catalog/<?=$h['id_cat']?>" class="cat_name" data-toggle="tooltip" data-placement="bottom" title="<?=$h['name_cat']?>"><?=$h['name_cat'];?></a></h1>
                                    <a href="/product/<?=$h['id_cat']?>/<?=$h['id']?>" class="linkimg"><img src="/image/<?=$h['imgname']?>"></a>
                                    <p class="name-pr" data-toggle="tooltip" data-placement="top" title="<?=$h['name']?>"><a href="/product/<?=$h['id_cat']?>/<?=$h['id']?>"><?=$h['name']?></a></p>
                                    <p class="price"><?=$h['price']?><span class="glyphicon glyphicon-ruble"></span></p>
                                    <p class="status">на складе</p>
                                    <div style="clear: both;"></div>
                                </div>
                            </div>
                        <?endforeach;?>
                    <?endif;?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="profile">
            <div class="wrap-slider-home">
                <div class="slider5">
                    <?if(count($sale)>0):?>
                        <?foreach($sale as $s):?>
                            <div class="slide">
                                <div class="item-slider-home">
                                    <h1><a href="/catalog/<?=$s['id_cat']?>" class="cat_name" data-toggle="tooltip" data-placement="bottom" title="<?=$s['name_cat']?>"><?=$s['name_cat'];?></a></h1>
                                    <a href="/product/<?=$h['id_cat']?>/<?=$s['id']?>" class="linkimg"><img src="/image/<?=$s['imgname']?>"></a>
                                    <p class="name-pr" data-toggle="tooltip" data-placement="top" title="<?=$s['name']?>"><a href="/product/<?=$h['id_cat']?>/<?=$s['id']?>"><?=$s['name']?></a></p>
                                    <p class="price"><?=$s['price']?><span class="glyphicon glyphicon-ruble"></span></p>
                                    <p class="status">на складе</p>
                                    <div style="clear: both;"></div>
                                </div>
                            </div>
                        <?endforeach;?>
                    <?endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

<? $this->registerJs("
    var sl1 = $('.slider4').bxSlider({
            slideWidth: 213,
            minSlides: 5,
            maxSlides: 5,
            moveSlides: 1,
            slideMargin: 10,
        });
    var sl2 = $('.slider5').bxSlider({
            slideWidth: 213,
            minSlides: 5,
            maxSlides: 5,
            moveSlides: 1,
            slideMargin: 10,
        });

        $('a[href=\"#home\"]').click(function () {
            $(this).tab('show');
            sl1.destroySlider();
            sl1.reloadSlider();
            return false;
        });
        $('a[href=\"#profile\"]').click(function () {
            $(this).tab('show');
            sl2.destroySlider();
            sl2.reloadSlider();
            return false;
        });

        $('.name-pr').tooltip();
        $('.cat_name').tooltip();
");?>