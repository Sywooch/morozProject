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
        <div class="form-home">
            <div class="block-form">
                <div class="ramka">
                    <h1>ИЩЕТЕ ЛУЧШЕЕ?</h1>
                    <p>Закажите консультацию у нас<br> и мы подберем для Вас лучшие<br> материалы для ремонта!</p>
                </div>
                <input type="text" class="home-input" name="name" value="" placeholder="Как Вас зовут?" />
                <input type="text" class="home-input" name="phone" value="" placeholder="Укажите ваш телефон?" />
                <div class="checkbox-modern">
                    <input type="checkbox" id="cd-checkbox-1" checked>
                    <label for="cd-checkbox-1">Нужна бесплатная консультация</label>
                </div>
                <button name="btn-cons" id="btn-cons" type="button">ЗАКАЗАТЬ КОНСУЛЬТАЦИЮ</button>
            </div>
        </div>
    </div>

    <div class="header-catalog-block">
        <div class="inner-block">
            <div class="inner-inner-block"><h1>ОНЛАЙН-КАТАЛОГ ТОВАРОВ ДЛЯ РЕМОНТА</h1></div>
        </div>
    </div>
    <div class="catalog-block">
        <div class="left-block">
        <table class="catalog-links-home">
            <tr>
                <td>
                    <div class="header-links">
                        <img src="image/cat1.jpg" alt=""/> <span>Напольные<br> покрытия</span>
                    </div>
                    <ul class="links-cat">
                        <li><span class="plus"></span><a href="#">Ламинат</a></li>
                        <li><span class="plus"></span><a href="#">Паркет</a></li>
                        <li><span class="plus"></span><a href="#">Линолиум</a></li>
                        <li><span class="plus"></span><a href="#">Теплый пол</a></li>
                        <li><span class="plus"></span><a href="#">Керамогранит</a></li>
                    </ul>
                </td>
                <td>
                    <div class="header-links">
                        <img src="image/cat2.jpg" alt=""/> <span>Подвесные<br> потолки</span>
                    </div>
                    <ul class="links-cat">
                        <li><span class="plus"></span><a href="#">Ламинат</a></li>
                        <li><span class="plus"></span><a href="#">Паркет</a></li>
                        <li><span class="plus"></span><a href="#">Линолиум</a></li>
                        <li><span class="plus"></span><a href="#">Теплый пол</a></li>
                        <li><span class="plus"></span><a href="#">Керамогранит</a></li>
                    </ul>
                </td>
                <td>
                    <div class="header-links">
                        <img src="image/cat3.jpg" alt=""/> <span>Настенные<br> покрытия</span>
                    </div>
                    <ul class="links-cat">
                        <li><span class="plus"></span><a href="#">Ламинат</a></li>
                        <li><span class="plus"></span><a href="#">Паркет</a></li>
                        <li><span class="plus"></span><a href="#">Линолиум</a></li>
                        <li><span class="plus"></span><a href="#">Теплый пол</a></li>
                        <li><span class="plus"></span><a href="#">Керамогранит</a></li>
                        <li><span class="plus"></span><a href="#">Линолиум</a></li>
                        <li><span class="plus"></span><a href="#">Теплый пол</a></li>
                        <li><span class="plus"></span><a href="#">Керамогранит</a></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="header-links">
                        <img src="image/cat4.jpg" alt=""/> <span>Мозайка</span>
                    </div>
                    <ul class="links-cat">
                        <li><span class="plus"></span><a href="#">Ламинат</a></li>
                        <li><span class="plus"></span><a href="#">Паркет</a></li>
                        <li><span class="plus"></span><a href="#">Линолиум</a></li>
                        <li><span class="plus"></span><a href="#">Теплый пол</a></li>
                        <li><span class="plus"></span><a href="#">Керамогранит</a></li>
                    </ul>
                </td>
                <td>
                    <div class="header-links">
                        <img src="image/cat5.jpg" alt=""/> <span>Двери</span>
                    </div>
                    <ul class="links-cat">
                        <li><span class="plus"></span><a href="#">Ламинат</a></li>
                        <li><span class="plus"></span><a href="#">Паркет</a></li>
                        <li><span class="plus"></span><a href="#">Линолиум</a></li>
                        <li><span class="plus"></span><a href="#">Теплый пол</a></li>
                        <li><span class="plus"></span><a href="#">Керамогранит</a></li>
                    </ul>
                </td>
                <td>
                    <div class="header-links">
                        <img src="image/cat6.jpg" alt=""/> <span>Сопутсвующие<br> товары</span>
                    </div>
                    <ul class="links-cat">
                        <li><span class="plus"></span><a href="#">Ламинат</a></li>
                        <li><span class="plus"></span><a href="#">Паркет</a></li>
                        <li><span class="plus"></span><a href="#">Линолиум</a></li>
                        <li><span class="plus"></span><a href="#">Теплый пол</a></li>
                        <li><span class="plus"></span><a href="#">Керамогранит</a></li>
                        <li><span class="plus"></span><a href="#">Линолиум</a></li>
                        <li><span class="plus"></span><a href="#">Теплый пол</a></li>
                        <li><span class="plus"></span><a href="#">Керамогранит</a></li>
                    </ul>
                </td>
            </tr>
        </table>
        </div>
        <div class="right-block-pages">
            <div class="wrap-right-block">
                <div class="header-right-pages">Профессиональный<br> монтаж</div>
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
                <div class="middle-header-right-block">Оперативная <br>доставка</div>
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
        <div style="clear: both;"></div>
    </div>

    <div class="forum-tabs">

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
