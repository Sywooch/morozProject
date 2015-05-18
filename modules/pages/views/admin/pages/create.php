<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\Tree */

$this->title = Yii::t('app', 'Create Pages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper-pages-index">
    <div class="head-block">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="row">
        <div class="col-md-3 mymd">
            <?= \yii\widgets\Menu::widget([
                'options' => ['class' => 'mynav-pages'],
                'items' => app\components\MenuHelper::getMenu(false),
                'submenuTemplate' => "\n<ul class='child'>\n{items}\n</ul>\n",
                'activateParents'=>true,
                'linkTemplate' => '<a href="{url}" style=""><span class="glyphicon glyphicon-file"></span> {label}</a>',
            ]) ?>

        </div>
        <div class="col-md-9 mymd">
            <div class="form-pages-block">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>