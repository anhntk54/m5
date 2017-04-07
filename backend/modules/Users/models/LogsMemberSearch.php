<?php

namespace backend\modules\Users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogsMemberSql;

/**
 * LogsMemberSearch represents the model behind the search form about `common\models\LogsMemberSql`.
 */
class LogsMemberSearch extends LogsMemberSql
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'member_id', 'table_id'], 'integer'],
            [['table_name', 'value', 'ip_address', 'created_at'], 'safe'],
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
        $query = LogsMemberSql::find();

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
            'member_id' => $this->member_id,
            'table_id' => $this->table_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address]);

        return $dataProvider;
    }
}
