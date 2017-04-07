<?php

namespace backend\modules\posts\models;

use Yii;
use common\func\FunctionCommon;
/**
 * This is the model class for table "taxonomy".
 *
 * @property integer $id
 * @property integer $table_id
 * @property string $table_name
 * @property string $type
 * @property string $value
 */
class Taxonomy extends \common\models\Taxonomy
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
            [['table_name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 100]
        ];
    }
    public static function setTaxonomy($table_id,$table_name,$type,$value) {
        $model = Taxonomy::findOne(['table_id'=>$table_id,'table_name'=>$table_name,'type'=>$type]);
        if (!$model) {
            $model = new Taxonomy;
            $model->table_id = $table_id;
            $model->table_name = $table_name;
            $model->type = $type;
        }
        $model->value = $value;
        $model->save();
        return $model;
    }
     public static function createSlug($id_post,$slug_post,$table_name_post,$isNew = TRUE) {
        $slugName = '';
        if (!$isNew) {
            $count = Taxonomy::find()->where(['value' =>$slug_post])->andWhere(['<>','table_id',$id_post])->andWhere(['table_name'=> $table_name_post])->count();
            $slugName = $slug_post;
            if ($count > 0) {
                $slugName .=  '-' . $count;
            }
            Taxonomy::setTaxonomy($id_post, $table_name_post, \common\func\StaticDefine::$SLUG, $slug_post);
        }  else {
            $slug_post = FunctionCommon::toSlug(FunctionCommon::stripVietnamese($slug_post));
            $count = Taxonomy::find()->where(['value' => $slug_post])->count();
            $slugName =$slug_post;
            if ($count > 0) {
                $slugName .=  '-' . $count;
            }
            Taxonomy::setTaxonomy($id_post, $table_name_post, \common\func\StaticDefine::$SLUG, $slug_post);
        }
        return $slugName;
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
