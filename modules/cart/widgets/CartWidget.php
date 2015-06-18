<?php
namespace app\modules\cart\widgets;
use Yii;
use yii\base\Widget;
use yii\web\Session;
use app\modules\cart\controllers\DefaultController;
/**
 * BayButton
 */
class CartWidget extends Widget
{
    public $no_wrap;

    public function init(){
        parent::init();
        if ($this->no_wrap === null) {
            $this->no_wrap = false;
        }
    }

    public function run(){
        $session = new Session;
        $session->open();
        $products = $session->get('products');

        $goods = DefaultController::getCart();

        return $this->render('Cart', [
                'products'=>$products,
                'no_wrap'=>$this->no_wrap,
                'goods'=>$goods,
        ]);
    }
}
