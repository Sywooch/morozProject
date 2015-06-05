<?php
namespace app\components\widgets;

use yii\base\Widget;
use Yii;


class HomePageWidget extends Widget{
    public $cat;
    public $pages;

    public function init(){
        parent::init();
        $db = Yii::$app->db;
        if(is_array($this->cat)&& count($this->cat)>0){
            $this->cat = $this->cat;
            foreach($this->cat as $c){
                $id_cat.="'".$c."',";
            }
            $id_cat = rtrim($id_cat,",");
            $cacheKey2 = 'wpages_data';
            $this->pages  = Yii::$app->cache->get($cacheKey2);
            if(!$this->pages) {
                $params = [':limit' => 10];
                $this->pages = $db->createCommand("SELECT * FROM tree WHERE parent IN ($id_cat) LIMIT :limit")->bindValues($params)->queryAll();
                Yii::$app->cache->set($cacheKey2, $this->pages, 3600);
            }
        }
    }

    public function run(){
        return $this->render('homepagewidget',[
            'pages'=>$this->pages,
        ]);
    }
}