<?php
    use app\modules\cart\widgets\BayButtonWidget;    
?>
<div class="cart-default-index">
  
    <?php
     // тестирование виджета кнопки
  //   echo BayButtonWidget::widget(['name' => 'Купить','goods_id'=>'1']);     
  //   echo BayButtonWidget::widget(['name' => 'Купить','goods_id'=>'2']);     
  //   echo BayButtonWidget::widget(['name' => 'Купить','goods_id'=>'3']);     
             ?>
    
   <?= $cart_view?>
    
     
</div>
