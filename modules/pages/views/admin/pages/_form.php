<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\pages\models\Tree;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\Tree */
/* @var $form yii\widgets\ActiveForm */

$items_first = array("0"=>"Корневая");
$items_db = ArrayHelper::map(Tree::find()->where(['!=', 'id', $model->id])->all(),'id','name');
$items = $items_first+$items_db;
?>

<div class="tree-form">

    <?php $form = ActiveForm::begin(); ?>
    <?//= $form->field($model, 'parent')->dropDownList($items) ?>
    <?=$form->field($model, 'parent')->widget(Select2::classname(), [
        'data' => $items,
        'language' => 'ru',
        /*'options' => ['placeholder' => 'Выберите категорию'],
        'pluginOptions' => [
            'allowClear' => true
        ],*/
    ]);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => 255]) ?>

    <?//= $form->field($model, 'html')->textarea(['rows' => 6]) ?>
    <?=$form->field($model, 'html')->widget(
        'trntv\aceeditor\AceEditor',
        [
            'mode'=>'php',
            'theme'=>'twilight'
        ]
    )?>

    <?= $form->field($model, 'metawords')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'metadesc')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?//= $form->field($model, 'createdate')->textInput() ?>

    <?=$form->field($model, 'createdate')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Дата создания'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
        ]
    ]);?>


    <?//= $form->field($model, 'updatedate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
