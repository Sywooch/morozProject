<?php
namespace app\components\widgets;

use yii\base\Widget;
use app\models\Call;
use Yii;


class CallWidget extends Widget{
    public $model;

    public function init(){
        parent::init();
        $this->model = new Call();
    }

    public function run(){
        return $this->render('call',['model'=>$this->model]);
    }
}