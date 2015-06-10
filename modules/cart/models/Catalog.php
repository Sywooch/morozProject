<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog".
 *
 * @property integer $id_cat
 * @property string $1c_id_cat
 * @property string $parent_1c_id_cat
 * @property integer $pid_cat
 * @property integer $type_cat
 * @property integer $status_cat
 * @property integer $prior_cat
 * @property string $link_cat
 * @property string $name_cat
 * @property string $title_cat
 * @property string $text_cat
 * @property string $text_small_cat
 * @property integer $create_date
 * @property string $keywords_cat
 * @property string $description_cat
 */
class Catalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_1c_id_cat', 'link_cat', 'text_cat', 'text_small_cat', 'keywords_cat', 'description_cat'], 'required'],
            [['pid_cat', 'type_cat', 'status_cat', 'prior_cat', 'create_date'], 'integer'],
            [['text_cat', 'text_small_cat', 'keywords_cat', 'description_cat'], 'string'],
            [['1c_id_cat', 'parent_1c_id_cat', 'name_cat', 'title_cat'], 'string', 'max' => 255],
            [['link_cat'], 'string', 'max' => 100],
            [['1c_id_cat'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cat' => Yii::t('app', 'Id Cat'),
            '1c_id_cat' => Yii::t('app', '1c Id Cat'),
            'parent_1c_id_cat' => Yii::t('app', 'Parent 1c Id Cat'),
            'pid_cat' => Yii::t('app', 'Pid Cat'),
            'type_cat' => Yii::t('app', 'Type Cat'),
            'status_cat' => Yii::t('app', 'Status Cat'),
            'prior_cat' => Yii::t('app', 'Prior Cat'),
            'link_cat' => Yii::t('app', 'Link Cat'),
            'name_cat' => Yii::t('app', 'Name Cat'),
            'title_cat' => Yii::t('app', 'Title Cat'),
            'text_cat' => Yii::t('app', 'Text Cat'),
            'text_small_cat' => Yii::t('app', 'Text Small Cat'),
            'create_date' => Yii::t('app', 'Create Date'),
            'keywords_cat' => Yii::t('app', 'Keywords Cat'),
            'description_cat' => Yii::t('app', 'Description Cat'),
        ];
    }
}
