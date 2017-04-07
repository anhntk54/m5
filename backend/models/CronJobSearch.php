<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CronJob;

/**
 * CronJobSearch represents the model behind the search form about `common\models\CronJob`.
 */
class CronJobSearch extends CronJob
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cron_id', 'table_id', 'status'], 'integer'],
            [['table_name', 'date_end'], 'safe'],
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
    public function search($params,$model = NULL)
    {
        $query = CronJob::find();
        if ($model) {
            $query = $query->where(['cron_id'=>$model->id]);
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
            'cron_id' => $this->cron_id,
            'table_id' => $this->table_id,
            'status' => $this->status,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'table_name', $this->table_name]);

        return $dataProvider;
    }
}
