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
        $db = Yii::$app->db;
        //$sql = 'SELECT * FROM goods WHERE id=:id';
        //$product = Goods::findBySql($sql, [':id' => $id])->one();
        $objProduct = Goods::findOne(['id' => $id]);
        $sql = "SELECT goods.* , attr_val.id_goods , attr_val.val_str, attr_val.new_price , attr_val.val_int , attr_val.val_text , spr.name_spr , spr_data.name_spr_data , attr.name as attrname , attr.name_val
                FROM attr_val
                LEFT JOIN spr_data ON attr_val.id_spr_data = spr_data.id_spr_data
                LEFT JOIN spr ON attr_val.id_spr = spr.id_spr
                LEFT JOIN attr ON attr_val.id_attr = attr.id
                LEFT JOIN goods ON attr_val.id_goods = goods.id
                WHERE attr_val.id_goods=:id
                ORDER BY attr.name DESC ";


        $params = [':id' => $id];
        $product = $db->createCommand($sql)
            ->bindValues($params)
            ->queryAll();
        $images = $objProduct->goodsImages;

        //vd($images[0]['imgname']);
        if($product){
            $finalGoods = array();
            foreach($product as $k=> $pr){
                $finalGoods[$pr['id']]['goods'] = $pr;
                if(!empty($pr['attrname'])){
                    if(!empty($pr['name_val'])&&$pr['name_val']==='val_str'){
                        $finalGoods[$pr['id']]['params'][$pr['attrname']][] = array($pr['val_str'],$pr['new_price']);
                    }
                    if(!empty($pr['name_val'])&&$pr['name_val']==='val_int'){
                        $finalGoods[$pr['id']]['params'][$pr['attrname']][] = array($pr['val_int'],$pr['new_price']);
                    }
                    if(!empty($pr['name_val'])&&$pr['name_val']==='val_text'){
                        $finalGoods[$pr['id']]['params'][$pr['attrname']][] = array($pr['val_text'],$pr['new_price']);
                    }
                }

                if(!empty($pr['name_spr'])){
                    $finalGoods[$pr['id']]['params'][$pr['name_spr']][] = array($pr['name_spr_data'],$pr['new_price']);
                }

            }

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
                $breadcrumbs[] = ['label' => $finalGoods[$id]['goods']['name']];
            }
        }else{
            throw new HttpException(404, 'Нет такой страницы');
        }

        return $this->render('index',[
            'breadcrumbs'=>$breadcrumbs,
            'current_cat'=>$current_cat,
            'product'=>$finalGoods,
            'images'=>$images,
            'id'=>$id,
        ]);
    }

}
