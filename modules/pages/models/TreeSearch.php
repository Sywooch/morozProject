<?php

namespace app\modules\pages\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pages\models\Tree;

/**
 * TreeSearch represents the model behind the search form about `app\modules\pages\models\Tree`.
 */
class TreeSearch extends Tree
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'sort'], 'integer'],
            [['name', 'title', 'link', 'html', 'metawords', 'metadesc', 'createdate'], 'safe'],
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
        $query = Tree::find();

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
            'createdate' => $this->createdate,
            //'updatedate' => $this->updatedate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'html', $this->html])
            ->andFilterWhere(['like', 'metawords', $this->metawords])
            ->andFilterWhere(['like', 'metadesc', $this->metadesc]);

        return $dataProvider;
    }
}
