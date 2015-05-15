<?php
namespace app\components;

use app\modules\pages\models\Tree;

class MenuHelper{
    public static function getMenu(){
        $role_id = 0;
        $result = static::getMenuRecrusive($role_id);
        return $result;
    }

    private static function getMenuRecrusive($parent){

        $items = Tree::find()
            ->where(['parent' => $parent])
            ->orderBy('sort')
            ->asArray()
            ->all();

        $result = [];

        foreach ($items as $item) {
            $result[] = [
                'label' => $item['name'],
                'url' => ['/admin/pages/view?id='.$item['id']],
                'items' => static::getMenuRecrusive($item['id']),
                '<li class="divider"></li>',
            ];
        }
        return $result;
    }
}