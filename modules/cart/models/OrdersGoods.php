<?php

namespace app\modules\cart\models;

use Yii;

/**
 * This is the model class for table "orders_goods".
 *
 * @property string $order_id
 * @property string $good_id
 *
 * @property Goods $good
 * @property Orders $order
 */
class OrdersGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'good_id'], 'required'],
            [['order_id', 'good_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app', 'Order ID'),
            'good_id' => Yii::t('app', 'Good ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Goods::className(), ['id' => 'good_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }
}
