<?php

namespace app\modules\catalog\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionView()
    {
        return $this->render('index');
    }
}
