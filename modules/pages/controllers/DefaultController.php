<?php

namespace app\modules\pages\controllers;

use yii\web\Controller;
use Yii;
use app\modules\pages\models\Tree;

class DefaultController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }


    public function actionView(){
        $url = Yii::$app->request->get('url');

        if(!empty($url)){
            $url = strip_tags($url);
            $db = Yii::$app->db;
            $params = [':url' => $url];
            $page = $db->createCommand("SELECT * FROM tree WHERE link = :url ")->bindValues($params)->queryOne();
        }
        return $this->render('view',[
            'page'=>$page
        ]);
    }
}
