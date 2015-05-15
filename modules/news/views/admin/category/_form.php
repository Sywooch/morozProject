<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\NewsCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$models = $dataProvider->getModels();
$arr = array("0"=>'Корневая категория');
foreach($models as $item){
    $arr[$item['id']] = $item['name'];
}
?>

<div class="news-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent')->dropDownList($arr) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'visible')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
