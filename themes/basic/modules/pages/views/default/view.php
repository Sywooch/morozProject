<?php
use yii\widgets\Breadcrumbs;
$this->title = $page['name'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-wrap">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?=$page['html'];?>
</div>