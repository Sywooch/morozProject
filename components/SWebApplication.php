<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 29.03.2015
 * Time: 19:39
 */

namespace app\components;


use yii\web\Application;
use Yii;
//use yii\base\Module;

class SWebApplication extends Application {

    public function __construct($config=null){
        parent::__construct($config);
    }
    public function init(){
        $this->_setSystemModules();
        parent::init();
    }

    protected function _setSystemModules(){
        //TODO: получаем из базы название класса компанента и id (название) модуля (всё кэшируем)
        $cacheKey = 'module_data';
        $modules    = Yii::$app->cache->get($cacheKey);
        if(!$modules){
            $modules = array("modules"=>array("admin"=>'app\modules\admin\AdminModule',"news"=>'app\modules\news\NewsModule',"pages"=>'app\modules\pages\PagesModule',"catalog"=>'app\modules\catalog\CatalogModule' ));
            Yii::$app->cache->set($cacheKey, $modules, 3600);
        }
        if($modules){
            foreach($modules as  $module){
                $this->setModules($module);
            }
        }

    }
}