<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Roses;

/**
 * RosesSearch represents the model behind the search form about `common\models\Roses`.
 */
class RosesSearch extends Roses
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'm5_id', 'member_id'], 'integer'],
            [['money', 'percent'], 'number'],
            [['type'], 'safe'],
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
        $query = Roses::find();

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
            'm5_id' => $this->m5_id,
            'member_id' => $this->member_id,
            'money' => $this->money,
            'percent' => $this->percent,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
