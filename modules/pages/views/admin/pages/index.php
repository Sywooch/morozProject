<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\components\MenuHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pages\models\TreeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tree-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tree'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?/*= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]) */?>

</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <?= \yii\widgets\Menu::widget([
                'items' => app\components\MenuHelper::getMenu(),
            ]) ?>

        </div>
        <div class="col-md-8">.col-md-8</div>
    </div>
</div>
