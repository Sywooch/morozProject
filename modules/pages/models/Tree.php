<?php

namespace app\modules\pages\models;

use Yii;

/**
 * This is the model class for table "tree".
 *
 * @property string $id
 * @property string $parent
 * @property string $name
 * @property string $title
 * @property string $link
 * @property string $html
 * @property string $metawords
 * @property string $metadesc
 * @property integer $sort
 * @property string $createdate
 * @property string $updatedate
 */
class Tree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'sort'], 'integer'],
            [['name', 'title', 'link', 'html', 'metawords', 'metadesc', 'createdate'], 'required'],
            [['html'], 'string'],
            [['desc'], 'string', 'max' => 255],
            [['createdate'], 'safe'],
            [['name', 'title', 'link', 'metawords', 'metadesc'], 'string', 'max' => 255],
            [['link'], 'unique','message' => 'Ссылка должна быть уникальна!']
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
            'title' => Yii::t('app', 'Title'),
            'link' => Yii::t('app', 'Link'),
            'desc' => Yii::t('app', 'Desc'),
            'html' => Yii::t('app', 'Html'),
            'metawords' => Yii::t('app', 'Metawords'),
            'metadesc' => Yii::t('app', 'Metadesc'),
            'sort' => Yii::t('app', 'Sort'),
            'createdate' => Yii::t('app', 'Createdate'),
            //'updatedate' => Yii::t('app', 'Updatedate'),
        ];
    }
}
