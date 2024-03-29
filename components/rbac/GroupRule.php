<?php
namespace app\components\rbac;

use Yii;
use yii\rbac\Rule;

class GroupRule extends Rule{
    public $name = 'group';
    public function execute($user, $item, $params){
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role;

            if ($item->name === 'superadmin') {
                return $role === $item->name;
            } elseif ($item->name === 'admin') {
                return $role === $item->name || $role === 'superadmin';
            } elseif ($item->name === 'moderator ') {
                return $role === $item->name || $role === 'superadmin' || $role === 'admin';
            } elseif ($item->name === 'user') {
                return $role === $item->name || $role === 'superadmin' || $role === 'admin' || $role === 'moderator';
            }
        }
        return false;
    }
}