<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="text-align: right;">
        <?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-plus"></span> Create News'), ['create'], ['class' => 'btn btn-add-admin']) ?>
    </p>
    <div class="head-block-table">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="search-rows" style="right: 0;"><span class="glyphicon glyphicon-search"></span></div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class' => 'table table-striped','id'=>'myTbl'],
        'layout'=>'{items}{summary}{pager}',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            //'description',
            //'text:ntext',
            'img',
            'date_create',
            'visible',
            //'news_category_id',
            //'newsCategory.name',
            [
                'attribute'=>'news_category_id',
                'value'=>'newsCategory.name',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<? $this->registerJs("

    $(function(){
        $('.filters').addClass('closeSearch');
        $(\".search-rows\").click(function () {
            $(\".filters\").toggleClass(\"closeSearch\");
        });
    });

");?>
