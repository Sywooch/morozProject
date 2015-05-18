<?php
namespace app\components;

use app\modules\pages\models\Tree;

class MenuHelper{
    public static function getMenu($public = true){
        $parent = 0;
        $res = Tree::find()->orderBy('sort')->asArray()->all();
        $arr = array();
        foreach($res as $ar){
            $arr[$ar['id']] = $ar;
        }
        if(!$public){
            $result = static::getMenuRecrusiveAdmin($arr,$parent);
        }else{
            $result = static::getMenuRecrusive($arr,$parent);
        }

        return $result;
    }





    private static function getMenuRecrusiveAdmin($arr,$parent = 0,$id_mat = NULL) {
        $print = '';
        $gategoryArr = $arr;
        $result = [];
        foreach ($gategoryArr as $category) {
            if ($parent == $category['parent']) {
                $result[] = [
                    'label' => $category['name'],
                    'url' => ['/admin/pages/update?id='.$category['id']],
                    'items' => static::getMenuRecrusiveAdmin($gategoryArr,$category['id']),
                ];
            }
        }
        return $result;
    }

    private static function getMenuRecrusive($arr,$parent = 0,$id_mat = NULL) {
        $print = '';
        $gategoryArr = $arr;
        $result = [];
        foreach ($gategoryArr as $category) {
            if ($parent == $category['parent']) {
                $result[] = [
                    'label' => $category['name'],
                    'url' => ['/pages/'.$category['link']],
                    'items' => static::getMenuRecrusive($gategoryArr,$category['id']),
                ];
            }
        }
        return $result;
    }
}