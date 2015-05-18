<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\MenuHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pages\models\TreeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?//= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <p style="text-align: right;">
        <?= Html::a(Yii::t('app', 'Create Tree'), ['create'], ['class' => 'btn btn-add-admin']) ?>
    </p>


<div class="wrapper-pages-index">
    <div class="row">
        <div class="head-block">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="search-rows" style="right: 0;"><span class="glyphicon glyphicon-search"></span></div>
        </div>
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
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions'=>['class' => 'table table-striped','id'=>'myTbl'],
                'layout'=>'{items}{summary}{pager}',
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'title',
                    'link',
                    'sort',
                    'createdate',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
<? $this->registerJs("

    $(function(){
        $('.filters').addClass('closeSearch');
        $(\".search-rows\").click(function () {
            $(\".filters\").toggleClass(\"closeSearch\");
        });
    });

");?>
