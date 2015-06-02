<?php
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
$this->title = 'Каталог';
?>



<div class="catalog-wrap">
    <div class="catalog-wrap-filters">left</div>
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
    });

");?>
