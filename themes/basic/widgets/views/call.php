<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="call-img"><img src="/image/call.jpg" alt=""/></div>
<div class="link-call"><a href="#" class="call-action">ОБРАТНЫЙ ЗВОНОК</a></div>

<?php
    Modal::begin([
        'header'=>'<h4>Обратный звонок</h4>',
        'id'=>'modal',
        'closeButton'=>['label'=>'<img src="/image/close.jpg" alt=""/>'],
        'size'=>'modal-sm',
    ]);
?>
    <div id="modalContent">
        <?php $form = ActiveForm::begin(['action'=>"/"]); ?>
        <?= $form->field($model, 'name',['template'=>'{error}{input}'])->textInput(['class'=>'home-input','placeholder'=>'Как Вас зовут?'])->label(""); ?>
        <?= $form->field($model, 'phone',['template'=>'{error}{input}'])->textInput(['class'=>'home-input','placeholder'=>'Укажите ваш телефон'])->label(""); ?>
        <button style="margin-top: 3px;" name="btn-cons" id="btn-cons" type="submit">ПЕРЕЗВОНИТЕ МНЕ</button>
        <?php ActiveForm::end(); ?>
    </div>
<?php Modal::end(); ?>

<? $this->registerJs("

    $(function(){
        $(\".call-action\").click(function () {
            $('#modal').modal('show');
            return false;
        });
    });

");?>