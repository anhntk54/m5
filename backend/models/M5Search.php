<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\M5;

/**
 * M5Search represents the model behind the search form about `common\models\M5`.
 */
class M5Search extends M5
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'member_id', 'cycle_id', 'status'], 'integer'],
            [['type', 'created_at', 'date_end'], 'safe'],
            [['money', 'money_current'], 'number'],
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
        $query = M5::find();

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
            'parent_id' => $this->parent_id,
            'member_id' => $this->member_id,
            'cycle_id' => $this->cycle_id,
            'money' => $this->money,
            'money_current' => $this->money_current,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
