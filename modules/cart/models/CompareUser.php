<?php

namespace app\modules\cart\models;

use Yii;
use yii\base\Model;


class CompareUser extends Model
{

    public $password;
    public $password_new;
    public $password_new_repeat;

    private $_user = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','password_new','password_new_repeat'], 'required'],
            [['password', 'password_new','password_new_repeat'], 'string', 'max' => 255],
            ['password', 'validatePassword'],
            ['password_new_repeat', 'compare', 'compareAttribute' => 'password_new'],
        ];
    }

    public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password_hash)) {
                $this->addError($attribute, 'Неверный пароль');
            }
        }
    }

    public function getUser(){
        if ($this->_user === false) {
            $this->_user = User::findOne(Yii::$app->getUser()->id);
        }
        return $this->_user;
    }

    public function generateNewPassword($newPassword){
        $password_hash = Yii::$app->security->generatePasswordHash($newPassword);
        if($password_hash){
            $user = $this->getUser();
            $user->password_hash = $password_hash;
            $user->save();
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => "Старый пароль",
            'password_new' => "Новый пароль",
            'password_new_repeat' => "Повторить новый пароль",
        ];
    }
}
