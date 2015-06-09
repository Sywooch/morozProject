<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "goods_images".
 *
 * @property string $id
 * @property string $1c_id
 * @property string $goods_id
 * @property string $1c_goods_id
 * @property string $imgname
 * @property string $chief
 *
 * @property Goods $goods
 */
class GoodsImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['1c_id', 'goods_id', '1c_goods_id', 'imgname'], 'required'],
            [['goods_id'], 'integer'],
            [['chief'], 'string'],
            [['1c_id', '1c_goods_id', 'imgname','desc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            '1c_id' => Yii::t('app', '1c ID'),
            'goods_id' => Yii::t('app', 'Goods ID'),
            '1c_goods_id' => Yii::t('app', '1c Goods ID'),
            'imgname' => Yii::t('app', 'Imgname'),
            'chief' => Yii::t('app', 'Chief'),
            'desc' => Yii::t('app', 'Desc'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }
}
