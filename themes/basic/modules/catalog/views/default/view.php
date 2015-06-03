<?php
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
$this->title = 'Каталог';
$min = 500; $max = 10000;
?>



<div class="catalog-wrap">
    <div class="catalog-wrap-filters">
        <div class="wrap-filters">
            <form action="#" method="get">
                <div class="block-form">
                    <h3>ЦЕНА</h3>

                    от <input type="text" id="minCost" value="500"/>
                    до <input type="text" id="maxCost" value="10000"/>

                    <div id="slider"></div>
                </div>
                <div class="block-form">
                    <h3>ПРОИЗВОДИТЕЛЬ</h3>

                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-1" name="pr[]" value="1" checked="">
                        <label for="cd-checkbox-1">Tarkett</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-2" name="pr[]" value="2" >
                        <label for="cd-checkbox-2">Синтерос</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-3" name="pr[]" value="3" >
                        <label for="cd-checkbox-3">Quick-Step</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-4" name="pr[]" value="4">
                        <label for="cd-checkbox-4">Aberhof</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-5" name="pr[]" value="5">
                        <label for="cd-checkbox-5">Kronostar</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-6" name="pr[]" value="6">
                        <label for="cd-checkbox-6">Premium</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-7" name="pr[]" value="7">
                        <label for="cd-checkbox-7">Floorwood</label>
                    </div>
                    <!--input type="checkbox" class="checkbox" id="checkbox" />
                    <label for="checkbox">Я переключаю чекбокс</label-->
                </div>
                <div class="block-form">
                    <h3>СТРАНА</h3>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-11" name="st[]" value="1">
                        <label for="cd-checkbox-11">Бельгия</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-12" name="st[]" value="2" >
                        <label for="cd-checkbox-12">Германия</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-13" name="st[]" value="3" >
                        <label for="cd-checkbox-13">Россия</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-14" name="st[]" value="4">
                        <label for="cd-checkbox-14">Китай</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-15" name="st[]" value="5">
                        <label for="cd-checkbox-15">Франция</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-16" name="st[]" value="6">
                        <label for="cd-checkbox-16">Автстрия</label>
                    </div>
                </div>
                <div class="block-form">
                    <h3>ЦВЕТ</h3>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-21" name="cl[]" value="1">
                        <label for="cd-checkbox-21">венге</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-22" name="cl[]" value="2" >
                        <label for="cd-checkbox-22">вишня</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-23" name="cl[]" value="3" >
                        <label for="cd-checkbox-23">орех</label>
                    </div>
                    <div class="checkbox-modern2">
                        <input type="checkbox" id="cd-checkbox-24" name="cl[]" value="4">
                        <label for="cd-checkbox-24">дуб классический</label>
                    </div>
                </div>
                <div class="btn-wrap">
                    <button type="button" name="out" class="btn-out">СБРОСИТЬ</button>
                    <button type="button" name="search" class="btn-search">НАЙТИ</button>
                </div>
            </form>
        </div>
        <div class="bottom-form">
            <div class="bot-left"></div>
            <div class="bot-right"></div>
        </div>

        <div class="wrap-leftpages-block">
            <div class="header-left-pages">Профессиональный<br> монтаж</div>
            <div class="item-right-pages">
                <a href="#">УСТАНОВКА ТЕПЛОГО ПОЛА</a>
                <p>от 5500 руб - 1 от дня</p>
            </div>
            <div class="item-right-pages">
                <a href="#">УКЛАДКА НАПОЛЬНЫХ ПОКРЫТИЙ</a>
                <p>от 2500 руб - 1 от дня</p>
            </div>
            <div class="item-right-pages">
                <a href="#">УСТАНОВКА ДВЕРИ</a>
                <p>от 5500 руб - 1 от дня</p>
            </div>
            <div class="item-right-pages">
                <a href="#">УКЛАДКА КЕРАМОГРАНИТА</a>
                <p>от 2500 руб - 1 от дня</p>
            </div>
            <div class="middle-header-left-block">Оперативная <br>доставка</div>
            <div class="item-right-pages">
                <a href="#">УСТАНОВКА ДВЕРИ</a>
                <p>от 5500 руб - 1 от дня</p>
            </div>
            <div class="item-right-pages">
                <a href="#">УКЛАДКА КЕРАМОГРАНИТА</a>
                <p>от 2500 руб - 1 от дня</p>
            </div>
        </div>


    </div>
    <div class="catalog-wrap-goods">
        <?if(is_array($child)  && count($child)>0):?>
        <div class="catalog-child-category">
            <?foreach($child as $ch):?>
                <a href="/catalog/<?=$ch['id_cat']?>"><?=$ch['name_cat']?></a>
            <?endforeach;?>
        </div>
        <?endif;?>
        <?php echo Breadcrumbs::widget([
            'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
            'links' => $breadcrumbs,
        ]);
        ?>
        <h1 style="padding-left: 30px;"><?=$cur_cat['name_cat']?></h1>
        <?php if(count($goods)>0):?>
            <div class="wrap-goods">
                <?foreach($goods as $g):?>
                    <div class="wrap-item-goods">
                        <div class="item-goods">
                            <a href="/product/<?=$g['id']?>"><img src="/image/p3.jpg" alt=""/></a>
                            <p id="good-name" class="name-pr" data-toggle="tooltip" data-placement="top" title="<?=$g['name']?>"><a href="/product/<?=$g['id']?>"><?=$g['name']?></a></p>
                            <p class="price" id="price"><?=$g['price']?><span class="glyphicon glyphicon-ruble"></span></p>
                            <p class="status" id="status">на складе</p>
                            <div style="clear: both"></div>
                            <div class="btn-buy">
                                <button type="button" name="buy" class="btn btn-braun">Купить</button>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
            <?php
            echo LinkPager::widget([
                'options'=>['class' => 'pagination','id'=>'catalog-pagination'],
                'firstPageLabel'=>'в начало',
                'lastPageLabel'=>'в конец',
                'pagination' => $pagination
            ]);
            ?>
        <?endif;?>
    </div>
</div>
<? $this->registerJs("

    $(function(){
        $('.name-pr').tooltip();
        var minR = ".$min.";
        var maxR = ".$max.";
        $('#slider').slider({
            min: minR,
            max: maxR,
            values: [minR,maxR],
            range: true,
            step:10,
            stop: function(event, ui) {
                $('input#minCost').val($('#slider').slider('values',0));
                $('input#maxCost').val($('#slider').slider('values',1));
            },
            slide: function(event, ui){
                $('input#minCost').val($('#slider').slider('values',0));
                $('input#maxCost').val($('#slider').slider('values',1));
            }
        });
        
        $('input#minCost').change(function(){
            var value1=$('input#minCost').val();
            var value2=$('input#maxCost').val();

            if (value1 < minR) { value1 = minR; $('input#minCost').val(minR)}

            if(parseInt(value1) > parseInt(value2)){
                value1 = value2;
                $('input#minCost').val(value1);
            }
            $('#slider').slider('values',0,value1);	
        });

        $('input#maxCost').change(function(){
            var value1=$('input#minCost').val();
            var value2=$('input#maxCost').val();
        
            if (value2 > maxR) { value2 = maxR; $('input#maxCost').val(maxR)}
        
            if(parseInt(value1) > parseInt(value2)){
                value2 = value1;
                $('input#maxCost').val(value2);
            }
            $('#slider').slider('values',1,value2);
        });
        
        // фильтрация ввода в поля
        $('input').keypress(function(event){
            var key, keyChar;
            if(!event) var event = window.event;
            if (event.keyCode) key = event.keyCode;
            else if(event.which) key = event.which;
            if(key==null || key==0 || key==8 || key==13 || key==9 || key==46 || key==37 || key==39 ) return true;
            keyChar=String.fromCharCode(key);
            if(!/\d/.test(keyChar))	return false;
        });
    });

");?>
