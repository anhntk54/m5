<?php

namespace backend\modules\posts\models;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $description
 * @property string $slug
 */
class Category extends \common\models\Category {

    public $icon;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'category';
    }
    function getIdChilds(){
        $arrs = [];
        foreach ($this->childs as $value) {
            $arrs[] = $value->id;
            if (count($value->childs) > 0) {
                $arrs = array_merge($arrs,$value->getIdChilds());
            }
        }
        return $arrs;
    }
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['parent_id','fb_image','status'], 'integer'],
            [['description', 'seo_title', 'seo_description', 'seo_keyword', 'fb_title', 'fb_description'], 'string'],
            [['title', 'slug','icon'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'parent_id' => 'Danh mục cha',
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'slug' => 'Slug',
            'seo_title' => "Seo Title",
            'seo_description' => "Seo Description",
            'seo_keyword' => "Keyword",
            'fb_title' => "Facebook Title",
            'fb_description' => 'FaceBook Description',
            'fb_image' => 'Ảnh FaceBook'
        ];
    }

    public function getCategoiesParent() {
        return \yii\helpers\ArrayHelper::map(Category::findAll("parent_id = 0"));
    }

}
