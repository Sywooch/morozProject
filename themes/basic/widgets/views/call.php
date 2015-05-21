<?php
use yii\bootstrap\Modal;
?>
<div class="call-img"><img src="/image/call.jpg" alt=""/></div>
<div class="link-call"><a href="#" class="call-action">ОБРАТНЫЙ ЗВОНОК</a></div>

<?php
    Modal::begin([
        'header'=>'<h4>Обратный звонок</h4>',
        'id'=>'modal',
        //'size'=>'modal-sm',
        'closeButton'=>['label'=>'<span class="glyphicon glyphicon-remove-circle myclose"></span>'],
    ]);
?>
    <div id="modalContent">Здесь будет форма для отправки заявки</div>
<?php Modal::end(); ?>

<? $this->registerJs("

    $(function(){
        $(\".call-action\").click(function () {
            $('#modal').modal('show');
            return false;
        });
    });

");?>