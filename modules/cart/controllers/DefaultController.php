<?php

namespace app\modules\cart\controllers;

use yii\web\Controller;
use Yii;
//use app\modules\catalog\models\Catalog;
use yii\web\HttpException;
use yii\data\Pagination;
use yii\web\Session;
use yii\web\Request;

use app\modules\cart\widgets\CartWidget; 

class DefaultController extends Controller{


    public function actionIndex(){
        
        $cart_view=$this->getCart();
        
        return $this->render('index',  [
                'cart_view'=>$cart_view,                
            ]);
    }
    public function getCart(){
        $session = new Session;
        $session->open();
        $products=$session->get('products');

        $goods=array();
        // получаем перечень товаров для вывода
        if(count($products)>0){
            $goods_id_string=  implode(",",array_keys($products));
            $db = Yii::$app->db;
            $goods = $db->createCommand("SELECT * FROM goods WHERE id IN ($goods_id_string)")->queryAll();
            foreach ($goods as  $key=>$goods_one){
                // TODO:если есть свойства, то доработать алгоритм
                if(isset($products[$goods_one['id']]['count'])){
                    $goods[$key]['count']=$products[$goods_one['id']]['count'];
                }
            }
        }
        return $this->renderPartial('cart',  [
                'goods'=>$goods,
                'products'=>$products,
            ]);
    }
    public function actionDel(){
        $session = new Session;
        $session->open();
        $products=$session->get('products');
        $goods_id=(int)Yii::$app->request->post('goods_id',1);
        unset($products[$goods_id]);
        $session->set('products',$products);         
        echo json_encode(array("ok"=>"true"));
        exit;
    }

    // пересчет товаров в корзине по ajax запросу
    public function actionBay(){
        // TODO: включить проверку ajax запроса
        $session = new Session;
        $session->open();
        $goods_id=(int)Yii::$app->request->post('goods_id',1);
        $count=(int)Yii::$app->request->post('cnt',1);
        
        $products=$session->get('products');
        // TODO: если товар имеет свойства, влияющие на цену, тогда $products_s[$id]['prop1_id']['count']         
        $products[$goods_id]['count'] = $count;
        // добавляем товар в сессию
        $session->set('products',$products);         

        // запускаем виджет карзины, который по сессионной переменной формирует карзину
        $cart_widget=CartWidget::widget(["no_wrap"=>true]); 
        echo json_encode(array("ok"=>"true","cart_widget"=>$cart_widget));
        exit;
        //return $this->render('index');
    }

}
