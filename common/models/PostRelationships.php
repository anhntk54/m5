<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_relationships".
 *
 * @property integer $post_id
 * @property integer $table_id
 * @property string $table_name
 * @property string $post_table
 */
class PostRelationships extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_relationships';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'table_id', 'table_name', 'post_table'], 'required'],
            [['post_id', 'table_id'], 'integer'],
            [['table_name'], 'string', 'max' => 20],
            [['post_table'], 'string', 'max' => 22]
        ];
    }
    public static function setPost($table_id,$id,$tbl_name,$type = 'posts') {
        $model = PostRelationships::findOne(['post_id'=>$id,'table_id'=>$table_id,'table_name'=>$tbl_name,'post_table'=>$type]);
        if (!$model) {
            $model = new PostRelationships;
            $model->table_id = $table_id;
            $model->table_name = $tbl_name;
            $model->post_id = $id;
            $model->post_table = $type;
            $model->save();
        }
        return $model;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'table_id' => 'Table ID',
            'table_name' => 'Table Name',
            'post_table' => 'Post Table',
        ];
    }
}
