<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\StringHelper;

if(count($news)>0){
    $this->title = $news['title'];
    $this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news']];
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="wrap-page-news">
    <div class="left-block-page-news">
        <?if(count($listnews)>0):?>
            <div class="wrap-figura-block-full">
                <div class="left-figura-full"></div>
                <div class="center-figura-full"><h1>ОБЗОР НОВОСТЕЙ</h1></div>
                <div class="right-figura-full"></div>
            </div>
            <div class="list-news-page-news">
                <?foreach($listnews as $list):?>
                    <?
                    if(count($news)>0) {
                        if ($list['id'] == $news['id']){
                            $bk = "yello-block";
                        }else{
                            $bk = "";
                        }
                    }
                    ?>
                    <div class="list-news-item <?=$bk;?>">
                        <p class="date-news"><?=date("d/m/Y",strtotime($list['date_create']))?> <a href="/news/<?=$list['id']?>" class="link-list-name"><?=$list['title']?></a></p>
                        <?if(!empty($list['img'])):?>
                        <div class="img-list-block">
                            <a href="/news/<?=$list['id'];?>"><img src="/uploads/news/<?= $list['img'] ?>" alt=""/></a>
                        </div>
                        <?endif;?>
                        <div class="desc-news"><?=StringHelper::truncateWords($list['description'],20,'...');?></div>
                    </div>
                <?endforeach;?>
            </div>
        <?endif;?>
    </div>
    <div class="right-block-page-news">
        <div class="item-news-page-news">
            <?if(count($news)>0):?>
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

                <h1><?=$news['title']?></h1>
                <p class="date-news"><?=date("d/m/Y",strtotime($news['date_create']))?></p>
                <div class="news-text">
                    <?=$news['text'];?>
                </div>
                <a href="/news"><button type="button" class="btn btn-braun"><span class="glyphicon glyphicon-menu-left"></span> К ОБЗОРУ НОВОСТЕЙ</button></a>
            <?endif;?>
        </div>
    </div>
</div>