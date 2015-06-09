<?php

namespace app\modules\catalog\controllers;
use app\modules\catalog\models\Goods;
use yii\web\Controller;
use Yii;
use app\modules\catalog\models\Catalog;
use yii\web\HttpException;
use yii\data\Pagination;
use app\modules\catalog\controllers\DefaultController;

class ProductController extends Controller
{
    public function actionIndex(){
        $id_cat = (int) Yii::$app->request->get('id_cat');
        $id = (int) Yii::$app->request->get('id');

        $sql = 'SELECT * FROM goods WHERE id=:id';
        $product = Goods::findBySql($sql, [':id' => $id])->one();
        $images = $product->goodsImages;

        //vd($images[0]['imgname']);
        if($product){
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

            if(array_key_exists($id_cat,$arr)){
                $current_cat = $arr[$id_cat];
                $breadcrumbs = DefaultController::breadcrumbs($arr,$id_cat);
                $breadcrumbs[] = ['label' => $product['name']];
            }
        }else{
            throw new HttpException(404, 'Нет такой страницы');
        }

        return $this->render('index',[
            'breadcrumbs'=>$breadcrumbs,
            'current_cat'=>$current_cat,
            'product'=>$product,
            'images'=>$images,
        ]);
    }

}
