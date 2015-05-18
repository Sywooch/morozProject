<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\pages\models\Tree;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\Tree */
/* @var $form yii\widgets\ActiveForm */

$items_first = array("0"=>"Корневая");
$items_db = ArrayHelper::map(Tree::find()->all(),'id','name');
$items = array_merge($items_first,$items_db);
?>

<div class="tree-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'parent')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'parent')->dropDownList($items) ?>

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

    <?= $form->field($model, 'createdate')->textInput() ?>

    <?= $form->field($model, 'updatedate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
