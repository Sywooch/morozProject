<?php
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use app\components\widgets\HomePageWidget;
use app\components\widgets\CaruselWidget;
use app\modules\cart\widgets\BayButtonWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Каталог';
if(isset($_GET['minprice']) || isset($_GET['maxprice'])){
    $min = (int)$_GET['minprice'];
    $max = (int)$_GET['maxprice'];
}else{
    $min = 500; $max = 10000;
}

?>

<div class="catalog-wrap">
    <div class="catalog-wrap-filters">
        <div class="wrap-filters">

            <form action="" method="get">
                <div class="block-form">
                    <h3>ЦЕНА</h3>

                    от <input type="text" name="minprice" id="minCost" value="<?=(isset($_GET['minprice'])?$_GET['minprice']:$min)?>"/>
                    до <input type="text" name="maxprice" id="maxCost" value="<?=(isset($_GET['maxprice'])?$_GET['maxprice']:$max)?>"/>

                    <div id="slider"></div>
                </div>

                <?if(is_array($filters) && count($filters)>0):?>
                    <?$key=0;?>
                    <?foreach($filters as $k=>$fil):?>
                        <div class="block-form">
                            <h3><?=$fil[0]['name_spr']?></h3>
                            <?foreach($fil as $kf=>$f):?>
                                <div class="checkbox-modern2">
                                    <input type="checkbox" id="cd-checkbox-<?=$key;?>" name="spr<?=$k?>[]" value="<?=$f['id_spr_data']?>" <?=(isset($_GET['spr'.$k]) && in_array($f['id_spr_data'],$_GET['spr'.$k])?"checked":'')?>>
                                    <label for="cd-checkbox-<?=$key;?>"><?=$f['name_spr_data']?></label>
                                </div>
                                <?$key++?>
                            <? endforeach;?>
                        </div>
                    <? endforeach;?>
                <?endif;?>


                <div class="btn-wrap">
                    <a href="/catalog/<?=$cur_cat['id_cat']?>" class="btn-out">СБРОСИТЬ</a>
                    <button type="submit" name="search" value="search" class="btn-search">НАЙТИ</button>
                </div>
            </form>
        </div>
        <div class="bottom-form">
            <div class="bot-left"></div>
            <div class="bot-right"></div>
        </div>

        <div class="wrap-leftpages-block">
            <?= HomePageWidget::widget(['cat'=>[16,17]]); ?>
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
            'itemTemplate' => "<li><i>{link}</i></li>\n",
            'links' => $breadcrumbs,
        ]);
        ?>
        <h1 style="padding-left: 30px;"><?=$cur_cat['name_cat']?></h1>
        <?php if(count($goods)>0):?>
            <div class="wrap-goods">
                <?foreach($goods as $g):?>
                    <div class="wrap-item-goods">
                        <div class="item-goods">
                            <?if(!empty($g['imgname'])):?>
                                <a class="imglink" href="/product/<?=$g['cat_id']?>/<?=$g['id']?>"><img src="/<?=$g['imgname']?>" alt=""/></a>
                            <?else:?>
                                <!-- заглушка-->
                                <a href="/product/<?=$g['cat_id']?>/<?=$g['id']?>"><img src="/image/noimg.jpg" alt=""/></a>
                            <?endif;?>

                            <p id="good-name" class="name-pr" data-toggle="tooltip" data-placement="top" title="<?=$g['name']?>"><a href="/product/<?=$g['cat_id']?>/<?=$g['id']?>"><?=$g['name']?></a></p>
                            <p class="price" id="price"><?=$g['price']?><span class="glyphicon glyphicon-ruble"></span></p>
                            <p class="status" id="status">на складе</p>
                            <div style="clear: both"></div>
                            <?=BayButtonWidget::widget(['name' => 'В корзину','count' => '10','goods_id'=>$g['id']]);?>
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
<?= CaruselWidget::widget(); ?>
<? $this->registerJs("

    $(function(){
        $('.name-pr').tooltip();
        var minR = ".$min.";
        var maxR = ".$max.";
        $('#slider').slider({
            min: 500,
            max: 10000,
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

            if (value1 < 500) { value1 = 500; $('input#minCost').val(500)}

            if(parseInt(value1) > parseInt(value2)){
                value1 = value2;
                $('input#minCost').val(value1);
            }
            $('#slider').slider('values',0,value1);	
        });

        $('input#maxCost').change(function(){
            var value1=$('input#minCost').val();
            var value2=$('input#maxCost').val();

            if (value2 > 10000) { value2 = 10000; $('input#maxCost').val(10000)}
        
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
