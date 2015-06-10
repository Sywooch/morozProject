<?php
namespace app\modules\cart\widgets;
use Yii;
//use app\modules\news\models\News;
use yii\base\Widget;
//use yii\web\NotFoundHttpException;
use yii\web\Session;
/**
 * BayButton
 */
class CartWidget extends Widget
{
    public $no_wrap;
//    public $goods_id;
    //public $count;
    public function init()
    {
        parent::init();

        if ($this->no_wrap === null) {
            $this->no_wrap = false;
        }
//        if ($this->goods_id === null) {
//            $this->goods_id = $this->goods_id;
//        }
        
    }

    public function run()
    {
        
//        $news = News::find()
//                 ->where([
//                     'visible' => 1,                     
//                     ])                
//                 ->orderBy(['date_news' => SORT_DESC])                
//                ->limit($this->count)
//                ->asArray()
//                ->all();
        $session = new Session;
        $session->open();
        $products=$session->get('products');
         return $this->render('Cart', [
                'products'=>$products,
                'no_wrap'=>$this->no_wrap,
            ]);
    }
}
