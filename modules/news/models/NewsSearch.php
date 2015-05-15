<?php

namespace app\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\news\models\News;

/**
 * NewsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title','news_category_id' ,'description', 'text', 'img', 'date_create', 'visible'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('newsCategory');

        $query->andFilterWhere([
            'id' => $this->id,
            'date_create' => $this->date_create,
            //'news_category_id' => $this->news_category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'news_category.name', $this->news_category_id])
            ->andFilterWhere(['like', 'visible', $this->visible]);

        return $dataProvider;
    }
}
