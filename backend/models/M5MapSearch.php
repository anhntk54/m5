<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\M5Map;
use common\models\M5;

/**
 * M5MapSearch represents the model behind the search form about `common\models\M5Map`.
 */
class M5MapSearch extends M5Map
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'm5_give_id', 'm5_take_id', 'cronjob_id', 'member_id', 'member_action', 'status', 'result', 'viewed'], 'integer'],
            [['money'], 'number'],
            [['create_at', 'date_end', 'date_status'], 'safe'],
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
    public function search($params,$model)
    {
        $query = M5Map::find();
        if ($model) {
            if ($model->type == M5::TYPE_GIVE) {
                $query = $query->where(['m5_give_id'=>$model->id]);
            }  else {
                $query = $query->where(['m5_take_id'=>$model->id]);
            }
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
            'm5_give_id' => $this->m5_give_id,
            'm5_take_id' => $this->m5_take_id,
            'cronjob_id' => $this->cronjob_id,
            'member_id' => $this->member_id,
            'member_action' => $this->member_action,
            'money' => $this->money,
            'status' => $this->status,
            'result' => $this->result,
            'viewed' => $this->viewed,
            'create_at' => $this->create_at,
            'date_end' => $this->date_end,
            'date_status' => $this->date_status,
        ]);

        return $dataProvider;
    }
}
