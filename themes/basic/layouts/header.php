<?php
use app\components\widgets\CallWidget;
use app\components\widgets\MenuCatalogWidget;
use app\components\widgets\MenuPagesWidget;
?>

<div class="forum-header">
    <div class="forum-logo"><a href="/" class="link-logo"><img src="/image/logo.jpg" alt=""/></a></div>
    <div class="time-delivery"><p>Доставка по Новосибирску <br> в течении одного дня <span>с 12:00 до 20:00</span></p></div>
    <div class="forum-call">
        <?= CallWidget::widget(); ?>
    </div>
    <div class="forum-phone">
        <p class="phone-text">Консультации и заказ по телефону:</p>
        <p class="phone-number">+7 (383) <span>292-56-89</span></p>
    </div>
</div>
<div class="line-menu">
    <div class="forum-menu-catalog">
        <?= MenuCatalogWidget::widget(); ?>
    </div>
    <div class="forum-menu-pages">
        <?= MenuPagesWidget::widget(); ?>
    </div>
    <div class="forum-cart"></div>
</div>