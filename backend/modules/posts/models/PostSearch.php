<?php

namespace backend\modules\posts\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\posts\models\Posts;

/**
 * PostSearch represents the model behind the search form about `backend\modules\posts\models\Posts`.
 */
class PostSearch extends Posts
{
    public $category_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id','category_id'], 'integer'],
            [['title', 'description','category_id', 'create_at', 'update_at', 'slug'], 'safe'],
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
    public function search($params,$filer,$type = 'post')
    {
        $this->load($params);
        if ($filer == 0){
            $query = Posts::find()->where(['type'=>$type]);
        }  else {
            $query = Posts::find()->where(['status'=>$filer,'type'=>$type]);
        }
        if ($this->category_id > 0) {
            $query->innerJoin('post_relationships','post_relationships.post_id = id')->where(['post_relationships.post_table'=>'posts','post_relationships.table_id'=>  $this->category_id,'post_relationships.table_name'=>'category']);
        }  
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
