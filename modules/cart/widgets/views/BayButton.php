<?
use yii\helpers\Html;
?>
<div class="widget-cart-baybutton">
   <div class="btn-buy" >
   		<div class="cart-count-block">
		    <a href="#" class="cart_down">-</a>
		    <input class="input_count" value="<?=$count?>">    
		    <a href="#" class="cart_up">+</a>
		    <button class="btn btn-braun cart-button-bay <?=$cls?>" name="buy" type="button" value="<?=$goods_id?>"><?=$name?></button>
			<div class="go-to-cart"></div>
		</div>
   </div>
</div>


