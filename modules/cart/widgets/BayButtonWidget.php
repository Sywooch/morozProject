<?php
namespace app\modules\cart\widgets;
use Yii;
//use app\modules\news\models\News;
use yii\base\Widget;
use yii\web\Session;
//use yii\web\NotFoundHttpException;

/**
 * BayButton
 */
class BayButtonWidget extends Widget
{
    public $name;
    public $goods_id;
    public $cls;
    public $count;

    public function init()
    {
        parent::init();
        if ($this->name === null) {
            $this->name = $this->name;
        }
        if ($this->goods_id === null) {
            $this->goods_id = $this->goods_id;
        }
        if ($this->count === null) {
            $this->count = $this->count;
        }

        $session = new Session;
        $session->open();
        $products=$session->get('products');
        if(isset($products[$this->goods_id]))
         {  
             $this->cls = ' in-cart';
             $this->name ="В корзине";
             if(isset($products[$this->goods_id]['count']))
                $this->count =$products[$this->goods_id]['count'];


         }
         else
         {
            $this->cls= '';        
         }
    }

    public function run()
    {
        
         
         return $this->render('BayButton', [
                'name'=>$this->name,
                'goods_id'=>$this->goods_id,
                'cls'=>$this->cls,
                'count'=> $this->count,
            ]);
    }
}
