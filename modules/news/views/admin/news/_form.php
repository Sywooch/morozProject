<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\news\models\NewsCategory;
use mihaildev\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 150]) ?>

    <?//= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    <?/*= $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'standard',
        ],
    ]);*/?>

    <?=$form->field($model, 'text')->widget(
        'trntv\aceeditor\AceEditor',
        [
            'mode'=>'php', // programing language mode. Default "html"
            'theme'=>'twilight' // editor theme. Default "github"
        ]
    )?>


    <?php
        if(isset($model->img)&&!empty($model->img)) {
            $title = isset($model->img) && !empty($model->img) ? $model->img : 'default_name';
            echo Html::img("/uploads/news/trumbs/trumb_" . $model->img, [
                'class' => 'img-thumbnail',
                'alt' => $title,
                'title' => $title
            ]);
        }
    ?>
    <?= $form->field($model, 'img')->fileInput() ?>

    <?= $form->field($model, 'date_create')->textInput() ?>

    <?= $form->field($model, 'visible')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ]) ?>

    <?= $form->field($model, 'news_category_id')->dropDownList(ArrayHelper::map(NewsCategory::find()->all(),'id','name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-add-admin' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
