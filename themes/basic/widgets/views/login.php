<div class="login-widget-wrap">
    <?if (!\Yii::$app->user->isGuest):?>
        <a href="/site/logout"><span class="glyphicon glyphicon-user"></span> ВЫХОД</a>
    <?else:?>
        <a href="/login"><span class="glyphicon glyphicon-user"></span> ВХОД</a>
    <?endif;?>
</div>