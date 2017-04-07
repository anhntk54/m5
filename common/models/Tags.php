<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $slug
 */
class Tags extends \yii\db\ActiveRecord {

    public $seo_title;
    public $seo_description;
    public $seo_keyword;
    public $fb_title;
    public $fb_description;
    public $fb_image;
    public $tinh_id, $huyen_id, $xa_id, $diadiem;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tags';
    }

    public static function setTagsValue($value) {
        $tag = Tags::findOne(['title' => $value]);
        if (!$tag) {
            $tag = new Tags;
            $tag->title = $value;
            $tag->save();
        }
        return $tag;
    }

    function getFbimage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'fbimages', 'post_table' => Tags::tableName()]);
                });
    }

    function getImage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'images', 'post_table' => Tags::tableName()]);
                });
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

}
