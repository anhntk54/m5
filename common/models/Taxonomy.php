<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "taxonomy".
 *
 * @property integer $id
 * @property integer $table_id
 * @property string $table_name
 * @property string $type
 * @property string $value
 */
class Taxonomy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'taxonomy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_id', 'table_name', 'type', 'value'], 'required'],
            [['table_id'], 'integer'],
            [['type'], 'string', 'max' => 100]
        ];
    }
    public static function getTaxonomy($table_id,$table_name,$type) {
        $model = Taxonomy::findOne(['table_id'=>$table_id,'table_name'=>$table_name,'type'=>$type]);
        if ($model) {
            return $model->value;
        }
        return '';
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_id' => 'Table ID',
            'table_name' => 'Table Name',
            'type' => 'Type',
            'value' => 'Value',
        ];
    }
}
