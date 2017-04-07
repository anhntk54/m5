<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cron;

/**
 * CronSearch represents the model behind the search form about `common\models\Cron`.
 */
class CronSearch extends Cron
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['min', 'date_end', 'hour', 'day', 'month', 'command', 'code'], 'safe'],
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
        $query = Cron::find();

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
            'date_end' => $this->date_end,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'min', $this->min])
            ->andFilterWhere(['like', 'hour', $this->hour])
            ->andFilterWhere(['like', 'day', $this->day])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'command', $this->command])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
