<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;


/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
        <?= $this->render('header') ?>

        <?php
            /*NavBar::begin([
                'brandLabel' => 'Магазин',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Главная', 'url' => ['/site/index']],
                    ['label' => 'Новости', 'url' => ['/news']],
                    ['label' => 'О нас', 'url' => ['/site/about']],
                    ['label' => 'Контакты', 'url' => ['/site/contact']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Вход', 'url' => ['/site/login']] :
                        ['label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();*/
        ?>

        <!--div class="container"-->
            <?/*= Breadcrumbs::widget([
                'homeLink'=>['label'=>'Главная','url'=>'/'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) */?>
            <?= $content ?>
        <!--/div-->
        <?= $this->render('footer') ?>
    </div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
