<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cycle;

/**
 * CycleSearch represents the model behind the search form about `common\models\Cycle`.
 */
class CycleSearch extends Cycle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cron_id', 'min', 'max', 'count_day', 'status'], 'integer'],
            [['date_begin', 'date_end'], 'safe'],
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
        $query = Cycle::find();

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
            'cron_id' => $this->cron_id,
            'min' => $this->min,
            'max' => $this->max,
            'count_day' => $this->count_day,
            'date_begin' => $this->date_begin,
            'date_end' => $this->date_end,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
