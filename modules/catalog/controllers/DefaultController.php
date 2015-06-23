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

        /*echo "<pre>";
        var_dump(Yii::$app->request->get());
        echo "</pre>";*/



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

            if(isset($_GET['search'])){
                $getArr = Yii::$app->request->get();
                if(isset($_GET['page'])){
                    $sectors = count($_GET)-5;
                }else{
                    $sectors = count($_GET)-4;
                }
                $minPrice = (int)strip_tags($getArr['minprice']);
                if($minPrice<500){
                    $minPrice = 500;
                }
                $maxPrice = (int)strip_tags($getArr['maxprice']);
                if($maxPrice<500){
                    $maxPrice = 500;
                }
                $str = "";
                if($sectors!=0) {
                    foreach ($getArr as $kg => $vg) {
                        if (is_array($vg)) {
                            $str .= " (z1.id_spr = " . (int)substr($kg, 3);
                            $str .= " AND (";
                            foreach ($vg as $v) {
                                $str .= " z2.id_spr_data = " . (int)$v . " OR ";
                            }
                            $str = rtrim($str, " OR ");
                            $str .= ")) OR ";

                        }
                    }
                    $str = rtrim($str, " OR ");

                    //если есть в фильтре справочники

                    $sqlCountGoods = "SELECT COUNT(DISTINCT goods.id)
                    FROM attr_val
                    LEFT JOIN spr_data ON attr_val.id_spr_data = spr_data.id_spr_data
                    LEFT JOIN spr ON attr_val.id_spr = spr.id_spr
                    LEFT JOIN attr ON attr_val.id_attr = attr.id
                    LEFT JOIN goods ON attr_val.id_goods = goods.id
                    WHERE goods.id IN
                    (SELECT t.id from
                    (
                        SELECT  count(z5.id) as  count, z5.id
                        FROM attr_val  z1
                        LEFT JOIN spr_data z2 ON z1.id_spr_data = z2.id_spr_data
                        LEFT JOIN spr z3 ON z1.id_spr = z3.id_spr
                        LEFT JOIN attr z4 ON z1.id_attr = z4.id
                        LEFT JOIN goods z5 ON z1.id_goods = z5.id
                        WHERE ".$str."
                        group by  z5.id
                    )  t
                    WHERE t.count = '$sectors') AND goods.cat_id IN ($childs) AND goods.price BETWEEN '$minPrice' AND '$maxPrice'";
                    //var_dump($sqlCountGoods);

                    $count = $db->createCommand($sqlCountGoods)->queryScalar();
                    $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>20,'forcePageParam' => false,'pageSizeParam' => false]);
                    $params = [':offset' => $pagination->offset, ':limit' => $pagination->limit];

                    $sqlGoods = "SELECT DISTINCT  goods.*, goods_images.imgname
                    FROM attr_val
                    LEFT JOIN spr_data ON attr_val.id_spr_data = spr_data.id_spr_data
                    LEFT JOIN spr ON attr_val.id_spr = spr.id_spr
                    LEFT JOIN attr ON attr_val.id_attr = attr.id
                    LEFT JOIN goods ON attr_val.id_goods = goods.id
                    LEFT JOIN goods_images ON goods_images.goods_id = goods.id AND goods_images.chief = 'Y'
                    WHERE goods.id IN
                    (SELECT t.id from
                    (
                        SELECT  count(z5.id) as  count, z5.id
                        FROM attr_val  z1
                        LEFT JOIN spr_data z2 ON z1.id_spr_data = z2.id_spr_data
                        LEFT JOIN spr z3 ON z1.id_spr = z3.id_spr
                        LEFT JOIN attr z4 ON z1.id_attr = z4.id
                        LEFT JOIN goods z5 ON z1.id_goods = z5.id
                        WHERE ".$str."
                        group by  z5.id
                    )  t
                    WHERE t.count = '$sectors') AND goods.cat_id IN ($childs) AND goods.price BETWEEN '$minPrice' AND '$maxPrice' LIMIT :offset,:limit" ;
                    $models = $db->createCommand($sqlGoods)->bindValues($params)->queryAll();
                    //var_dump($sqlGoods);


                }else{
                    //фильтр только по цене
                    $sql = "SELECT COUNT(*) FROM goods WHERE cat_id IN ($childs) AND price BETWEEN '$minPrice' AND '$maxPrice'";
                    $count = $db->createCommand($sql)->queryScalar();
                    $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>20,'forcePageParam' => false,'pageSizeParam' => false]);
                    $params = [':offset' => $pagination->offset, ':limit' => $pagination->limit];
                    $models = $db->createCommand("
                          SELECT goods.*, goods_images.imgname, catalog.link_cat, catalog.id_cat FROM goods
                          LEFT JOIN goods_images ON goods_images.goods_id = goods.id AND goods_images.chief = 'Y'
                          LEFT JOIN catalog ON catalog.id_cat = goods.cat_id
                          WHERE goods.cat_id IN ($childs) AND price BETWEEN '$minPrice' AND '$maxPrice' LIMIT :offset,:limit
                    ")->bindValues($params)->queryAll();
                }
            }else{
                //$sql = "SELECT COUNT(*) FROM goods WHERE cat_id IN ($childs)";
                $count = $db->createCommand("SELECT COUNT(*) FROM goods WHERE cat_id IN ($childs)" )->queryScalar();

                $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>20,'forcePageParam' => false,'pageSizeParam' => false]);
                $params = [':offset' => $pagination->offset, ':limit' => $pagination->limit];
                $models = $db->createCommand("
                      SELECT goods.*, goods_images.imgname, catalog.link_cat, catalog.id_cat FROM goods
                      LEFT JOIN goods_images ON goods_images.goods_id = goods.id AND goods_images.chief = 'Y'
                      LEFT JOIN catalog ON catalog.id_cat = goods.cat_id
                      WHERE goods.cat_id IN ($childs) LIMIT :offset,:limit
                ")->bindValues($params)->queryAll();
            }



            //filters
            $filters = $db->createCommand("
                SELECT spr.id_spr, spr.name_spr, spr.is_filter,  spr.filter_type, spr_data.id_spr_data, spr_data.name_spr_data  FROM spr
                LEFT JOIN spr_data ON spr.id_spr = spr_data.parent_id_spr_data
                WHERE spr.id_spr IN (
                    SELECT DISTINCT attr_val.id_spr FROM goods
                    LEFT JOIN attr_val ON attr_val.id_goods = goods.id
                    WHERE goods.cat_id IN ($childs) AND attr_val.id_spr !=''
                ) AND spr.is_filter = '1' ORDER BY spr_data.name_spr_data + 0")->queryAll();

            $finalFilters = array();
            foreach($filters as $f){
                $finalFilters[$f['id_spr']][] = $f;
            }

        }else{
            throw new HttpException(404, 'Нет такой страницы');
        }

        return $this->render('view',[
            'breadcrumbs' => $breadcrumbs,
            'child'=>$ch_categories,
            'goods'=>$models,
            'pagination'=>$pagination,
            'cur_cat'=>$current_cat,
            'filters'=>$finalFilters,
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


    public function actionFind(){

        return $this->render('find',[
            'breadcrumbs' => $breadcrumbs,
            'child'=>$ch_categories,
            'goods'=>$models,
            'pagination'=>$pagination,
            'cur_cat'=>$current_cat,
            'filters'=>$filters,
        ]);
    }

}
