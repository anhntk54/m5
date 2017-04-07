<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transactions;

/**
 * TransactionsSearch represents the model behind the search form about `common\models\Transactions`.
 */
class TransactionsSearch extends Transactions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'member_id', 'count', 'money', 'status'], 'integer'],
            [['created_at', 'type'], 'safe'],
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
    public function search($params,$fiter)
    {
        if ($fiter == 0) {
            $query = Transactions::find()->where(['type'=>"Pin"]);
        }
        if ($fiter == 1) {
            $query = Transactions::find()->where(['table_id'=>0,'type'=>"Pin"]);
        }
        if ($fiter == 5) {
            $query = Transactions::find()->where(['status'=>$fiter,'type'=>"Pin"]);
        }
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
            'count' => $this->count,
            'money' => $this->money,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
