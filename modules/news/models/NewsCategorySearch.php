<?php

namespace app\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\news\models\NewsCategory;
use yii\data\SqlDataProvider;

/**
 * NewsCategorySearch represents the model behind the search form about `app\modules\news\models\NewsCategory`.
 */
class NewsCategorySearch extends NewsCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'sort'], 'integer'],
            [['name', 'link', 'visible'], 'safe'],
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

        $query = NewsCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent' => $this->parent,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'visible', $this->visible]);

        return $dataProvider;
    }

    public function category($id){

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM news_category WHERE id !=:id',
            'params' => [':id' => $id],
        ]);
        return $dataProvider;
    }
}
