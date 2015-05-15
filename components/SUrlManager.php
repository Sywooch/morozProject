<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 29.03.2015
 * Time: 18:46
 */

namespace app\components;
use yii\web\UrlManager;
use Yii;


class SUrlManager extends UrlManager {
    public function init(){
        $this->_loadModuleUrls();
        parent::init();
    }

    protected function _loadModuleUrls(){
        //TODO: всё кэшируем
        $cacheKey = 'url_manager_urls';
        //$rules    = Yii::$app->cache->get($cacheKey);
        $rules = false;
        if(!$rules){
            $rules       = array();
            $modules     = array("news");
            $modulesPath = Yii::getAlias('@app')."\modules";
            foreach($modules as $module){
                $configFilePath = implode(DIRECTORY_SEPARATOR, array($modulesPath, $module, 'config', 'routes.php'));
                if(file_exists($configFilePath)){
                    $rules = array_merge(require($configFilePath), $rules);
                }
            }
            Yii::$app->cache->set($cacheKey, $rules, 3600);
        }

        $this->rules = array_merge($rules, $this->rules);
    }
}