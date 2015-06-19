<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = 'Ваши покупки';
$all_sum=0;
?>
<div class="wrap-figura-block" style="margin-top: 20px;">
    <div class="left-figura"></div>
    <div class="center-figura"><h1>ВАШИ ПОКУПКИ</h1></div>
    <div class="right-figura"></div>
</div>
<div class="line-figura"></div>
<?if(count($goods)>0):?>
    <table  class="cart-table-goods">
        <tr>
            <th></th>
            <th class="cart-name">Наименование</th>
            <th>Цена за ед.</th>
            <th>Количество</th>
            <th >Стоимость</th>
        </tr>
        <?foreach($goods as $g):?>
            <?php $all_sum = $all_sum + $g['price']*$g['count'];?>

            <tr class="table-item-goods" data-goods-id="<?=$g['id']?>" id="row_goods_<?=$g['id']?>">

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
                    <?=$g['count']?>
                </td>
                <td class="cart-sum">
                    <span class="cart-sum-val"><?=$g['price']*$g['count']?></span><span class="glyphicon glyphicon-ruble"></span>
                </td>
            </tr>
        <?endforeach;?>
        <tr>
            <td colspan="6" class="cart_itogo">
                <div  class="all-sum">Итого: <span id="all-sum-val"><?=$all_sum?></span><span class="glyphicon glyphicon-ruble"></span></div>
            </td>
        </tr>
    </table>

    <div class="wrap-figura-block" style="margin-top: 20px;">
        <div class="left-figura"></div>
        <div class="center-figura"><h1>ОФОРМЛЕНИЕ ЗАКАЗА</h1></div>
        <div class="right-figura"></div>
    </div>
    <div class="line-figura"></div>


    <?if(!\Yii::$app->user->isGuest):?>
        <?php $form = ActiveForm::begin(['id' => 'orders-form']); ?>
        <div class="row" style="margin:0;">
            <div class="col-md-6">
                <div class="form-orders-wrap">
                    <h3>Контактная информация</h3>
                    <?= $form->field($model, 'username',['template' => "<div class='row'><div class=\" col-lg-3\">{label}</div>\n<div class=\"col-lg-8\">{input}</div></div>"])->label("Ваше имя * :"); ?>
                    <?= $form->field($model, 'email',['template' => "<div class='row'><div class=\" col-lg-3\">{label}</div>\n<div class=\"col-lg-8\">{input}</div></div>"])->label("Email * :"); ?>
                    <?= $form->field($model, 'phone',['template' => "<div class='row'><div class=\" col-lg-3\">{label}</div>\n<div class=\"col-lg-8\">{input}</div></div>"])->label("Телефон * :"); ?>
                    <?= $form->field($model, 'comment',['template' => "<div class='row'><div class=\" col-lg-3\">{label}</div>\n<div class=\"col-lg-8\">{input}</div></div>"])->textarea()->label("Коментарий :"); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-orders-wrap">
                    <h3>Способ доставки</h3>
                    <?= $form->field($model, 'delivery',['enableLabel' => false])->radioList(
                        [
                            "nov"=>"ДОСТАВКА ПО НОВОСИБИРСКУ <span>(бесплатно при заказе на сумму более 10000 руб.)</span>",
                            "sam"=>"САМОВЫВОЗ",
                            "city"=>"ДОСТАВКА В ДРУГИЕ ГОРОДА",
                        ],
                        [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return  Html::radio($name, ($value=='nov' ? ' checked' : ''), ['value' => $value]) ." ". $label."<br>";
                            },
                        ]
                    ) ?>
                    <?= $form->field($model, 'address')->textarea()->label("Адрес * :"); ?>
                </div>
            </div>
        </div>
        <div class="line-price">
            <h3>Стоимость доставки: <span id="dprice"></span></h3>
            <h3>Итого к оплате: <span id="sumprice"></span></h3>
            <?= Html::submitButton('ЗАКАЗАТЬ', ['class' => 'btn btn-orange forum-btn', 'name' => 'signup-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?else:?>
        <div class="forum-tabs">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="first-tb active"><div class="bglefttab"></div><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Вход</a><div class="bgrigthtab"></div></li>
                <li role="presentation"><div class="bglefttab"></div><a href="#sign" aria-controls="sign" role="tab" data-toggle="tab">Регистрация</a><div class="bgrigthtab"></div></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="login">
                    <div class="site-login">
                        <h1>Вход</h1>
                        <p>Пожалуйста, заполните следующие поля для входа:</p>
                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                        ]); ?>
                        <?= $form->field($LoginModel, 'email') ?>
                        <?= $form->field($LoginModel, 'password')->passwordInput()->label('Пароль')?>
                        <?= $form->field($LoginModel, 'rememberMe', [
                            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ])->checkbox()->label('Запомнить меня') ?>
                        <div style="margin: 15px 0;">
                            Если вы забыли свой пароль вы можете, <?= Html::a('сбросить его', ['site/request-password-reset']) ?>.
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton('Войти', ['class' => 'btn btn-yellow', 'name' => 'login-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="sign">
                    <div class="site-login">
                        <h1>Регистрация</h1>
                        <p>Пожалуйста, заполните следующие поля, чтобы зарегистрироваться:</p>
                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                        <?= $form->field($signModel, 'username')->label("Ваше имя"); ?>
                        <?= $form->field($signModel, 'email') ?>
                        <?= $form->field($signModel, 'password')->passwordInput(); ?>
                        <div class="form-group">
                            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-yellow', 'name' => 'signup-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

        </div>
    <?endif;?>
<?else:?>
    <div class="alert alert-danger">
        <p>Нет заказа</p>
    </div>
<?endif;?>


<? $this->registerJs("
    $(function(){
        var input = $('input[name=\"User[delivery]\"]');
        var OSum = ".$all_sum.";
        input.each(function(){
            if($(this).val()==='nov' && $(this)[0].checked){
                $(this).next().next().after(\"<select name='district' class='form-control' id='district'><option value='300' selected>Дзержинский район</option><option value='200'>Железнодорожный район</option><option value='200'>Заельцовский район</option><option value='400'>Калининский район</option><option value='600'>Кировский район</option><option value='200'>Заельцовский район</option><option value='700'>Ленинский район</option><option value='200'>Октябрьский район</option><option value='1000'>Первомайский район</option><option value='200'>Советский район</option><option value='200'>Центральный район</option></select>\")
                var pr = $('#district').attr('selected', 'selected').val();
                var SUM = parseInt(pr)+ parseInt(OSum);
                $('#dprice').html(pr+\" <span class='glyphicon glyphicon-ruble'></span> \");
                $('#sumprice').html(SUM+\" <span class='glyphicon glyphicon-ruble'></span> \");
            }
        });

        input.click(function(){
            $('#district').remove();
            if($(this).val()==='nov' && $(this)[0].checked){
                $(this).next().next().after(\"<select name='district' class='form-control' id='district'><option value='300'>Дзержинский район</option><option value='200'>Железнодорожный район</option><option value='200'>Заельцовский район</option><option value='400'>Калининский район</option><option value='600'>Кировский район</option><option value='200'>Заельцовский район</option><option value='700'>Ленинский район</option><option value='200'>Октябрьский район</option><option value='1000'>Первомайский район</option><option value='200'>Советский район</option><option value='200'>Центральный район</option></select>\")
                var pr = $('#district').attr('selected', 'selected').val();
                $('#dprice').html(pr+\" <span class='glyphicon glyphicon-ruble'></span> \");
            }
            if($(this).val()==='city' && $(this)[0].checked){
                $('#dprice').html(\"1000 <span class='glyphicon glyphicon-ruble'></span> \");
                var SUM = parseInt(1000)+ parseInt(OSum);
                $('#sumprice').html(SUM+\" <span class='glyphicon glyphicon-ruble'></span> \");
            }
            if($(this).val()==='sam' && $(this)[0].checked){
                $('#dprice').html(\"0 <span class='glyphicon glyphicon-ruble'></span> \");
                var SUM = parseInt(OSum);
                $('#sumprice').html(SUM+\" <span class='glyphicon glyphicon-ruble'></span> \");
            }
        });

        $(document).on('change','#district', function() {
            $('#dprice').html(this.value+\" <span class='glyphicon glyphicon-ruble'></span> \");
            var SUM = parseInt(this.value)+ parseInt(OSum);
            $('#sumprice').html(SUM+\" <span class='glyphicon glyphicon-ruble'></span> \");
        });
    });
");?>