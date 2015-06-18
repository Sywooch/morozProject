<?php

namespace app\modules\cart\models;
use app\modules\cart\models\User;
use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property string $id
 * @property string $user_id
 * @property string $sum_total
 * @property string $sum_delivery
 * @property string $create_date
 * @property string $oplata_date
 * @property string $update_date
 * @property string $status
 * @property string $dump_cart
 *
 * @property OrdersGoods[] $ordersGoods
 * @property Goods[] $goods
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sum_total', 'sum_delivery', 'create_date', 'dump_cart'], 'required'],
            [['user_id'], 'integer'],
            [['sum_total', 'sum_delivery'], 'number'],
            [['create_date', 'oplata_date', 'update_date'], 'safe'],
            [['status', 'dump_cart'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'sum_total' => Yii::t('app', 'Sum Total'),
            'sum_delivery' => Yii::t('app', 'Sum Delivery'),
            'create_date' => Yii::t('app', 'Create Date'),
            'oplata_date' => Yii::t('app', 'Oplata Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'status' => Yii::t('app', 'Status'),
            'dump_cart' => Yii::t('app', 'Dump Cart'),
        ];
    }

    public function sendEmail($goods,$delivery_sum,$order_id){
        $user = User::findOne([
            'id' => Yii::$app->getUser()->id,
        ]);

        if ($user) {
            return \Yii::$app->mailer->compose(['html' => 'orders-html'], ['user' => $user,'goods'=>$goods,'delivery_sum'=>$delivery_sum,'order_id'=>$order_id])
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->params['siteName']])
                ->setTo($user->email)
                ->setSubject('Ваш заказ от '.\Yii::$app->params['siteName'])
                ->send();
        }

        return false;
    }
    public function sendEmailAdmin($goods,$delivery_sum,$order_id){
        $user = User::findOne([
            'id' => Yii::$app->getUser()->id,
        ]);

        if ($user) {
            return \Yii::$app->mailer->compose(['html' => 'orders-html'], ['user' => $user,'goods'=>$goods,'delivery_sum'=>$delivery_sum,'order_id'=>$order_id])
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->params['siteName']])
                ->setTo(\Yii::$app->params['adminEmail'])
                ->setSubject('Новый заказ от пользователя ID'.$user->id)
                ->send();
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersGoods()
    {
        return $this->hasMany(OrdersGoods::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Goods::className(), ['id' => 'good_id'])->viaTable('orders_goods', ['order_id' => 'id']);
    }
}
