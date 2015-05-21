<?php
namespace app\components\widgets;

use yii\base\Widget;


class CallWidget extends Widget{
    public $message;

    public function init(){
        parent::init();

    }

    public function run(){
        return $this->render('call');
    }
}