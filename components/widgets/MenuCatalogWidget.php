<?php
namespace app\components\widgets;

use yii\base\Widget;
use app\modules\catalog\models\Catalog;
use Yii;

class MenuCatalogWidget extends Widget{
    public $result;


    public function init(){
        parent::init();
        $cacheKey = 'categories_data';
        $res  = Yii::$app->cache->get($cacheKey);
        if(!$res) {
            $res = Catalog::find()->orderBy('prior_cat')->asArray()->all();
            Yii::$app->cache->set($cacheKey, $res, 3600);
        }
        $arr = array();
        foreach($res as $ar){
            $arr[$ar['id_cat']] = $ar;
        }
        $this->result = static::getMenuRecrusive($arr,1);
    }

    public function run(){
        return $this->render('menucatalog',[
            'cat' => $this->result,
        ]);
    }

    private static function getMenuRecrusive($arr,$parent = 0) {
        $print = '';
        $gategoryArr = $arr;
        $result = [];
        foreach ($gategoryArr as $key=> $category) {
            if ($parent == $category['pid_cat']) {
                $result[$category['id_cat']] = [
                    'label' => $category['name_cat'],
                    'url' => ['/catalog/'.$category['id_cat']],
                    'items' => static::getMenuRecrusive($gategoryArr,$category['id_cat']),
                ];
            }
        }
        return $result;
    }
}