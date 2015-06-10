<?
//use yii\helpers\Html;
?>
<?if(!$no_wrap):?>
<div class="cart-widget-wrap">
<?endif;?>
<a href="/cart"><span class="img-cart"></span>КОРЗИНА (<?=count($products)?>)</a>
<?if(!$no_wrap):?>
</div>
<?endif;?>
