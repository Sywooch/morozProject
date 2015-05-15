<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-index">
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
<!--    <p>--><?//= Html::a(Yii::t('app', 'Create News Category'), ['create'], ['class' => 'btn btn-success']) ?><!--</p>-->
    <div class="head-block-table">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="add-rows btn-add"><span class="glyphicon glyphicon-plus-sign"></span></div>
        <div class="search-rows"><span class="glyphicon glyphicon-search"></span></div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class' => 'table table-striped','id'=>'myTbl'],
        //'summary'=>false,
        'layout'=>'{items}{summary}{pager}',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent',
            'name',
            'link',
            'visible',
            // 'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<div id="sForm" class="sForm sFormPadding">
    <p class="btn-add closebtn"><span class="glyphicon glyphicon-plus-sign"></span></p>
    <h2 class="title">Добавить категорию</h2>
    <div class="wr-form-addnews">
        <?= $this->render('_formIndex', [
            'model' => $model,
            'dataProvider'=>$dataProvider
        ]) ?>
    </div>
</div>
<? $this->registerJs("

    $(function(){
        $(\".btn-add\").click(function () {
            $(\"#sForm\").toggleClass(\"openFormNews\");
        });
        $('.filters').addClass('closeSearch');
        $(\".search-rows\").click(function () {
            $(\".filters\").toggleClass(\"closeSearch\");
        });
    });

");?>