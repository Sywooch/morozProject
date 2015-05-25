<?php
$this->title = 'Магазин';
?>
<div class="forum-home">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?=Yii::$app->session->getFlash('success')?>
        </div>
    <?php endif;?>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?=Yii::$app->session->getFlash('error')?>
        </div>
    <?php endif;?>

    <div class="baner-form-wrap">
        <div class="baner-home">
            <div class="inner-baner">
                <div class="block-text block-t"><p>ТОВАРЫ ДЛЯ <br> РЕМОНТА</p></div>
                <img src="/image/b1.jpg" alt=""/>
            </div>
            <div class="inner-baner">
                <img src="/image/b2.jpg" alt=""/>
                <div class="block-text block-pr"><p>В РОЗНИЦУ<br>ПО ОПТОВЫМ <br>ЦЕНАМ</p></div>
            </div>
            <div class="inner-baner">
                <div class="block-text block-f"><p>«ФОРУМ-НОВОСИБИРСК»<br> ЭТО ИНТЕРНЕТ СУПЕРМАРКЕТ<br> ТОВАРОВ ДЛЯ РЕМОНТА И <br>СОПУТСВУЮЩИХ ТОВАРОВ</p></div>
                <img src="/image/b3.jpg" alt=""/>
            </div>
            <div class="inner-baner">
                <img src="/image/b4.jpg" alt=""/>
                <div class="block-text block-z"><p>ЗАКАЗЫВАЙТЕ ИЗ ДОМА И<br> ПОЛУЧАЙТЕ СВОЙ<br> ЗАКАЗ В ТЕЧЕНИИ СУТОК В<br> УДОБНОЕ ВРЕМЯ</p></div>
            </div>
        </div>
        <div class="form-home">form</div>
    </div>


</div>

<? $this->registerJs("

    $(function(){
        var HI=$(\".inner-baner img\").height();
        $(\".block-text\").height(HI);
        $(\".form-home\").height(HI*2);
        $(window).resize(function(){
            HI=$(\".inner-baner img\").height();
            $(\".block-text\").height(HI);
            $(\".form-home\").height(HI*2);
        });

    });

");?>
