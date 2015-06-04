<?php
namespace app\modules\news\components\widgets;

use yii\base\Widget;
use Yii;


class NewsWidget extends Widget{
    public $cat;
    public $news;

    public function init(){
        parent::init();
        $db = Yii::$app->db;
        if($this->cat !==null){
            $this->cat = (int)$this->cat;
            $cacheKey2 = 'news_data';
            $this->news  = Yii::$app->cache->get($cacheKey2);
            if(!$this->news) {
                $params = ['cat'=>$this->cat,':limit' => 5];
                $this->news = $db->createCommand("SELECT * FROM news WHERE news_category_id=:cat LIMIT :limit")->bindValues($params)->queryAll();
                Yii::$app->cache->set($cacheKey2, $this->news, 3600);
            }
        }
    }

    public function run(){
        return $this->render('@app/themes/basic/widgets/views/news',[
            'news'=>$this->news,
        ]);
    }
}