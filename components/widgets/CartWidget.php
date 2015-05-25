<?php
namespace app\components\widgets;

use yii\base\Widget;


class CartWidget extends Widget{
    public $message;

    public function init(){
        parent::init();

    }

    public function run(){
        return $this->render('cart');
    }
}