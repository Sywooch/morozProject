<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Панель администратора',
                'brandUrl' => "/admin",
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'items' => [
                    ['label' => '<span class="glyphicon glyphicon-home"></span> Главная', 'url' => ['/admin']],
                    [
                        'label' => '<span class="glyphicon glyphicon-inbox"></span> Новости',
                        'items' => [
                            ['label' => '<span class="glyphicon glyphicon-th-list"></span> Категории', 'url' => ['/admin/news/category']],
                            ['label' => '<span class="glyphicon glyphicon-file"></span> Новости', 'url' => ['/admin/news']],
                        ],
                    ],
                    ['label' => '<span class="glyphicon glyphicon-file"></span> Страницы', 'url' => ['/admin/pages']],

                ],
                'encodeLabels'=>false,
                'activateItems'=>true,
                'activateParents'=>true,
                'options' => ['class' => 'navbar-nav navbar-left'],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'encodeLabels'=>false,
                'homeLink'=>['label'=>'<span class="glyphicon glyphicon-home"></span> Главная','url'=>'/admin'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
