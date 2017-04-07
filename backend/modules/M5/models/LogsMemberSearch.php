<?php

namespace backend\modules\M5\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogsMember;

/**
 * LogsMemberSearch represents the model behind the search form about `common\models\LogsMember`.
 */
class LogsMemberSearch extends LogsMember
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'table_id', 'table_name', 'member_id', 'created_at', 'value', 'ip_address'], 'safe'],
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
        $query = LogsMember::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'table_id', $this->table_id])
            ->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'member_id', $this->member_id])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address]);

        return $dataProvider;
    }
}
