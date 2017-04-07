<?php

namespace backend\modules\config\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\config\models\Banner;

/**
 * BannerSearch represents the model behind the search form about `backend\modules\config\models\Banner`.
 */
class BannerSearch extends Banner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'new_tab', 'banner_order'], 'integer'],
            [['name', 'url', 'value', 'position', 'date_begin', 'date_end', 'type'], 'safe'],
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
        $query = Banner::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'new_tab' => $this->new_tab,
            'date_begin' => $this->date_begin,
            'date_end' => $this->date_end,
            'banner_order' => $this->banner_order,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
