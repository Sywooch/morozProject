<?php
use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Здравсвуйте, <?= Html::encode($user->username) ?>!</p>

    <p>Перейдите по ссылке чтобы сменить пароль:</p>

    <p><?php echo Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
