<?php

namespace app\modules\news\models;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $img
 * @property string $date_create
 * @property string $visible
 * @property string $news_category_id
 *
 * @property NewsCategory $newsCategory
 */
class News extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'text', 'date_create', 'news_category_id'], 'required'],
            [['text', 'visible'], 'string'],
            [['date_create'], 'safe'],
            [['news_category_id'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['img'], 'file','extensions'=>'jpg, gif, png,jpeg','maxSize'=>2097152],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title News'),
            'description' => Yii::t('app', 'Description News'),
            'text' => Yii::t('app', 'Text News'),
            'img' => Yii::t('app', 'Img'),
            'date_create' => Yii::t('app', 'Date Create'),
            'visible' => Yii::t('app', 'Visible'),
            'news_category_id' => Yii::t('app', 'News Category'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategory()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'news_category_id']);
    }
}
