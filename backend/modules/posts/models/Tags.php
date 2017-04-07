<?php

namespace backend\modules\posts\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 */
class Tags extends \common\models\Tags {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['id','fb_image'], 'integer'],
            [['description','seo_title', 'seo_description', 'seo_keyword', 'fb_title', 'fb_description'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    public static function setTagsValue($value) {
        $tag = Tags::findOne(['title' => $value]);
        if (!$tag) {
            $tag = new Tags;
            $tag->title = $value;
            $tag->save();
            $tag->slug = Taxonomy::createSlug($tag->id, $tag->title, Tags::tableName());
            $tag->save();
        }
        return $tag;
    }
    function getSeoPost() {
        $taxonomy = Taxonomy::findOne(['table_name' => Tags::tableName(), 'type' => \common\func\StaticDefine::$SEO_BAI_VIET, 'table_id' => $this->id]);
        if ($taxonomy) {
            $json[] = json_decode($taxonomy->value);
            $this->seo_title = $json[0]->seo_title;
            $this->seo_description = $json[0]->seo_description;
            $this->seo_keyword = $json[0]->seo_keyword;
            $this->fb_description = $json[0]->fb_description;
            $this->fb_title = $json[0]->fb_title;
            if ($this->fbimage) {
                $this->fb_image = $this->fbimage->id;
            }
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'seo_title' => "Seo Title",
            'seo_description' => "Seo Description",
            'seo_keyword' => "Keyword",
            'fb_title' => "Facebook Title",
            'fb_description' => 'FaceBook Description',
            'fb_image' => 'Ảnh FaceBook'
        ];
    }

}
