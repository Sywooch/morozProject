<?php
use yii\widgets\LinkPager;
use yii\widgets\Breadcrumbs;
use yii\helpers\StringHelper;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-default-index">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <div class="wrap-figura-block">
        <div class="left-figura"></div>
        <div class="center-figura"><h1>ОБЗОР НОВОСТЕЙ</h1></div>
        <div class="right-figura"></div>
    </div>
    <div class="line-figura"></div>
    <div class="news-wrap-list">
        <?if(count($news)>0):?>
            <?foreach($news as $n):?>
                <div class="wrap-items-news">
                    <div class="item-news">
                        <?if(!empty($n['img'])):?>
                        <a href="/news/<?=$n['id'];?>"><img src="/uploads/news/trumbs/trumb_<?= $n['img'] ?>" alt=""/></a>
                        <?endif;?>
                        <p class="date-news"><?=date("d/m/Y",strtotime($n['date_create']))?></p>
                        <h2><a href="/news/<?=$n['id'];?>"><?=$n['title']?></a></h2>
                        <div class="desc-news"><?=StringHelper::truncateWords($n['description'],20,'...');?></div>
                    </div>
                </div>
            <?endforeach;?>

        <?endif;?>
    </div>
    <?php
        echo LinkPager::widget([
            'options'=>['class' => 'pagination','id'=>'catalog-pagination'],
            'firstPageLabel'=>'в начало',
            'lastPageLabel'=>'в конец',
            'pagination' => $pages
        ]);
    ?>
</div>
