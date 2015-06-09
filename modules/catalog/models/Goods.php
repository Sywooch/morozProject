<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property string $id
 * @property integer $cat_id
 * @property string $id_1c
 * @property string $cat_id_1c
 * @property integer $goods_type
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property integer $prior
 * @property integer $visible
 * @property string $price
 * @property string $articul
 * @property string $status
 * @property integer $sklad
 * @property string $hit
 * @property string $sale
 *
 * @property GoodsImages[] $goodsImages
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'id_1c', 'cat_id_1c', 'name', 'alias', 'description', 'prior', 'visible', 'price'], 'required'],
            [['cat_id', 'goods_type', 'prior', 'visible', 'sklad'], 'integer'],
            [['description', 'hit', 'sale'], 'string'],
            [['price'], 'number'],
            [['id_1c', 'cat_id_1c', 'articul'], 'string', 'max' => 100],
            [['name', 'alias'], 'string', 'max' => 300],
            [['status'], 'string', 'max' => 10],
            [['id_1c'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_id' => Yii::t('app', 'Cat ID'),
            'id_1c' => Yii::t('app', 'Id 1c'),
            'cat_id_1c' => Yii::t('app', 'Cat Id 1c'),
            'goods_type' => Yii::t('app', 'Goods Type'),
            'name' => Yii::t('app', 'Name'),
            'alias' => Yii::t('app', 'Alias'),
            'description' => Yii::t('app', 'Description'),
            'prior' => Yii::t('app', 'Prior'),
            'visible' => Yii::t('app', 'Visible'),
            'price' => Yii::t('app', 'Price'),
            'articul' => Yii::t('app', 'Articul'),
            'status' => Yii::t('app', 'Status'),
            'sklad' => Yii::t('app', 'Sklad'),
            'hit' => Yii::t('app', 'Hit'),
            'sale' => Yii::t('app', 'Sale'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsImages()
    {
        return $this->hasMany(GoodsImages::className(), ['goods_id' => 'id']);
    }
}
