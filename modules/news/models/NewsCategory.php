<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the model class for table "news_category".
 *
 * @property string $id
 * @property string $parent
 * @property string $name
 * @property string $link
 * @property string $visible
 * @property integer $sort
 */
class NewsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'sort'], 'integer'],
            [['name', 'link', 'sort'], 'required'],
            [['visible'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['link'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent' => Yii::t('app', 'Parent'),
            'name' => Yii::t('app', 'Name'),
            'link' => Yii::t('app', 'Link'),
            'visible' => Yii::t('app', 'Visible'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }


    public function getNews(){
        return $this->hasMany(News::className(), ['news_category_id' => 'id']);
    }
}
