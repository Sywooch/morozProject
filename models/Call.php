<?php

namespace app\models;

use yii\base\Model;
use Yii;

class Call extends Model
{
    public $name;
    public $phone;

    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => "Имя",
            'phone' => "Телефон",
        ];
    }
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom("robot@shop.ru")
                ->setSubject("Обратный звонок-консультация")
                ->setTextBody("Пользователь ".$this->name." просит перезвонить по номеру ".$this->phone)
                ->send();

            return true;
        } else {
            return false;
        }
    }
}