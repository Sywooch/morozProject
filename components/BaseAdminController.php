<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 16.04.2015
 * Time: 14:41
 */
namespace app\components;
use Yii;
use yii\web\Controller;



class BaseAdminController extends Controller{
    public $layout = '@app/modules/admin/views/layouts/admin';

    public function behaviors(){

        /*if(!Yii::$app->user->can('admin')){
            return $this->redirect('/site/login',302);
        }

        return [];*/
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],

            ],
        ];
    }

}