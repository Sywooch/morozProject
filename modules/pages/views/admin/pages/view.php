<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\Tree */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="wrapper-pages-index">
        <div class="head-block">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row">
            <div class="col-md-4 mymd">
                <?= \yii\widgets\Menu::widget([
                    'options' => ['class' => 'mynav-pages'],
                    'items' => app\components\MenuHelper::getMenu(false),
                    'submenuTemplate' => "\n<ul class='child'>\n{items}\n</ul>\n",
                    'activateParents'=>true,
                    'linkTemplate' => '<a href="{url}" style=""><span class="glyphicon glyphicon-file"></span> {label}</a>',
                ]) ?>

            </div>
            <div class="col-md-8 mymd">
                <div class="form-pages-block">
                <p>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'parent',
                        'name',
                        'title',
                        'link',
                        //'html:ntext',
                        'metawords',
                        'metadesc',
                        'sort',
                        'createdate',
                        'updatedate',
                    ],
                ]) ?>
                </div>
            </div>
        </div>
    </div>

