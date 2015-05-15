<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-default-index">
    <?foreach($news as $n):?>
        <h2><?=$n['title']?></h2>
    <?endforeach;?>
    <?php
        echo LinkPager::widget([
            //'pagination' => $pages->pagination
            'pagination' => $pages
        ]);
    ?>
</div>
