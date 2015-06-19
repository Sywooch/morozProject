<?php
use app\components\widgets\HomePageWidget;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = "Личный кабинет";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-account">
    <div class="forum-account-left">
        <div class="wrap-leftpages-block" style="margin-top: 40px;">
            <?= HomePageWidget::widget(['cat'=>[16,17]]); ?>
        </div>
    </div>
    <div class="forum-account-content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="forum-history-orders">
            <h1>Добро пожаловать в Ваш личный кабинет!</h1>
            <?php if (Yii::$app->session->hasFlash('pass_complete')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?=Yii::$app->session->getFlash('pass_complete')?>
                </div>
            <?php endif;?>
            <?php if (Yii::$app->session->hasFlash('pass_error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?=Yii::$app->session->getFlash('pass_error')?>
                </div>
            <?php endif;?>
            <div class="forum-lk-header">
                <h3><img src="/image/romb.png" alt=""/>История Ваших заказов</h3>
            </div>
            <?if(count($orders)>0):?>
                <div class="wrap-tbl-orders">
                    <table class="table table-striped">
                        <tr>
                            <th>№</th>
                            <th>Дата заказа</th>
                            <th>Сумма, руб</th>
                            <th>Сумма доставки, руб.</th>
                            <th>Статус</th>
                        </tr>
                        <?foreach($orders as $o):?>
                            <tr>
                                <td><?=$o['id']?></td>
                                <td><?=Yii::$app->formatter->asDate($o['create_date'], 'd MMMM yyyy') ?></td>
                                <td><?=$o['sum_total']?></td>
                                <td><?=$o['sum_delivery']?></td>
                                <td>
                                    <?if($o['status']==='Y'):?>
                                        <span class="lbl-green">оплачен</span>
                                    <?else:?>
                                        <span class="lbl-red">не оплачен</span>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?endforeach;?>
                    </table>
                </div>
            <?else:?>
                <div class="alert alert-info">Нет заказов</div>
            <?endif;?>

            <div class="forum-lk-header">
                <h3><img src="/image/romb.png" alt=""/>Ваши регистрационные данные</h3>
            </div>
            <div class="forum-lk-header">
                <h3><img src="/image/romb.png" alt=""/>Изменение пароля</h3>
            </div>
            <div class="compare-password">
                <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($compareUserModel, 'password',['template' => "<div class='row'><div class=\" col-lg-3\">{label}</div>\n<div class=\"col-lg-9\">{input}{error}</div></div>"])->textInput(['maxlength' => 45, 'class' => 'form-control']) ?>
                    <?= $form->field($compareUserModel, 'password_new',['template' => "<div class='row'><div class=\" col-lg-3\">{label}</div>\n<div class=\"col-lg-9\">{input}{error}</div></div>"])->passwordInput(['class' => 'form-control']) ?>
                    <?= $form->field($compareUserModel, 'password_new_repeat',['template' => "<div class='row'><div class=\" col-lg-3\">{label}</div>\n<div class=\"col-lg-9\">{input}{error}</div></div>"])->passwordInput(['class' => 'form-control']) ?>
                    <div style="text-align: right;">
                        <?= Html::submitButton('СМЕНИТЬ ПАРОЛЬ', ['class' => 'btn btn-orange forum-btn', 'name' => 'signup-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>