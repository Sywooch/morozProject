<?php

namespace app\modules\admin\controllers;

use app\components\BaseAdminController;

class DefaultController extends BaseAdminController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}
