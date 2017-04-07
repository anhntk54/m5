<?php

namespace backend\modules\config\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\config\models\Trangthai;

/**
 * TrangthaiSearch represents the model behind the search form about `backend\modules\posts\models\Trangthai`.
 */
class TrangthaiSearch extends Trangthai
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['ten', 'mo_ta', 'type', 'thuoc_tinh'], 'safe'],
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
        $query = Trangthai::find();

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
        ]);

        $query->andFilterWhere(['like', 'ten', $this->ten])
            ->andFilterWhere(['like', 'mo_ta', $this->mo_ta])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'thuoc_tinh', $this->thuoc_tinh]);

        return $dataProvider;
    }
}
