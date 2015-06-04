<?php
namespace app\components\widgets;

use yii\base\Widget;
use Yii;


class CaruselWidget extends Widget{
    public $hit;
    public $sale;

    public function init(){
        parent::init();

        $db = Yii::$app->db;

        // hit
        $cacheKey = 'hit_data';
        $this->hit  = Yii::$app->cache->get($cacheKey);
        if(!$this->hit) {
            $params = [':limit' => 10];
            $this->hit = $db->createCommand("SELECT goods.*, goods_images.imgname, catalog.name_cat,catalog.id_cat FROM goods
                                              LEFT JOIN catalog ON catalog.id_cat = goods.cat_id
                                              LEFT JOIN goods_images ON goods_images.goods_id = goods.id AND goods_images.chief = 'Y'
                                              WHERE goods.hit = 'Y' LIMIT :limit")->bindValues($params)->queryAll();
            Yii::$app->cache->set($cacheKey, $this->hit, 3600);
        }

        //sale
        $cacheKey2 = 'sale_data';
        $this->sale  = Yii::$app->cache->get($cacheKey2);
        if(!$this->sale) {
            $params = [':limit' => 10];
            $this->sale = $db->createCommand("SELECT goods.*, goods_images.imgname, catalog.name_cat,catalog.id_cat FROM goods
                                              LEFT JOIN catalog ON catalog.id_cat = goods.cat_id
                                              LEFT JOIN goods_images ON goods_images.goods_id = goods.id AND goods_images.chief = 'Y'
                                              WHERE goods.sale = 'Y' LIMIT :limit")->bindValues($params)->queryAll();
            Yii::$app->cache->set($cacheKey2, $this->sale, 3600);
        }


    }

    public function run(){
        return $this->render('carusel',[
            'hit'=>$this->hit,
            'sale'=>$this->sale,
        ]);
    }
}