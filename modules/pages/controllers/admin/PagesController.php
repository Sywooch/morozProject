<?php

namespace app\modules\pages\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\BaseAdminController;


/**
 * NewsController implements the CRUD actions for News model.
 */
class PagesController extends BaseAdminController
{
    /*public function behaviors()
     {
         return [
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     'delete' => ['post'],
                 ],
             ],
         ];
     }*/

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex(){
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}