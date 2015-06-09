<?php

namespace app\modules\catalog\controllers;

use yii\web\Controller;
use Yii;
use app\modules\catalog\models\Catalog;
use yii\web\HttpException;
use yii\data\Pagination;

class DefaultController extends Controller{


    public function actionIndex(){
        return $this->render('index');
    }

    /*
     * ТОвары в категории
     */
    public function actionView(){
        $id_cat = (int) Yii::$app->request->get('url');

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
            $breadcrumbs = self::breadcrumbs($arr,$id_cat);
            //дочернии категории
            $child = self::cats_id($arr,$id_cat);
            if($child){
                $child = rtrim($child,',');
                $ch_arr = explode(",",$child);
                $ch_categories = Catalog::findAll($ch_arr);
            }
            // Товары
            $childs = self::cats_id_all($arr,$id_cat);
            $childs = "'".$id_cat."',".$childs;
            $childs = rtrim($childs,',');

            $db = Yii::$app->db;
            $sql = "SELECT COUNT(*) FROM goods WHERE cat_id IN ($childs)";
            $count = $db->createCommand("SELECT COUNT(*) FROM goods WHERE cat_id IN ($childs)" )->queryScalar();

            $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>20,'forcePageParam' => false,'pageSizeParam' => false]);
            $params = [':offset' => $pagination->offset, ':limit' => $pagination->limit];
            $models = $db->createCommand("
                      SELECT goods.*, goods_images.imgname, catalog.link_cat, catalog.id_cat FROM goods
                      LEFT JOIN goods_images ON goods_images.goods_id = goods.id AND goods_images.chief = 'Y'
                      LEFT JOIN catalog ON catalog.id_cat = goods.cat_id
                      WHERE goods.cat_id IN ($childs) LIMIT :offset,:limit
                ")->bindValues($params)->queryAll();

        }else{
            throw new HttpException(404, 'Нет такой страницы');
        }

        return $this->render('view',[
            'breadcrumbs' => $breadcrumbs,
            'child'=>$ch_categories,
            'goods'=>$models,
            'pagination'=>$pagination,
            'cur_cat'=>$current_cat,
        ]);
    }

    /**
     * Получение ID  дочерних категорий
     **/
    public static function cats_id($array, $id){
        if(!$id) return false;
        $data = null;
        foreach($array as $item){
            if($item['pid_cat'] == $id){
                $data .= $item['id_cat'] . ",";
            }
        }
        return $data;
    }

    /**
     * Получение ID  всех дочерних категорий
     **/
    public static function cats_id_all($array, $id){
        if(!$id) return false;
        $data = null;
        foreach($array as $item){
            if($item['pid_cat'] == $id){
                $data .= "'".$item['id_cat']."'" . ",";
                $data .= self::cats_id_all($array, $item['id_cat']);
            }
        }
        return $data;
    }

    /**
     * Хлебные крошки
     **/
    public static function breadcrumbs($array, $id){
        if(!$id) return false;

        $count = count($array);
        $breadcrumbs_array = array();
        for($i = 0; $i < $count; $i++){
            if(isset($array[$id]) && $array[$id]['id_cat']!='1'){
                $breadcrumbs_array[]= [
                    'label' => $array[$id]['name_cat'],
                    'url' => ['/catalog/'.$array[$id]['id_cat']],
                ];
                $id = $array[$id]['pid_cat'];

             }else break;
        }
        return array_reverse($breadcrumbs_array, true);
    }

}
