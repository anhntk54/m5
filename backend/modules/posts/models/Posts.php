<?php

namespace backend\modules\posts\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $description
 * @property string $post_type
 * @property integer $post_order
 * @property string $create_at
 * @property string $update_at
 * @property string $slug
 */
class Posts extends \common\models\Posts {


    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['author_id', 'title', 'description', 'slug'], 'required'],
            [['author_id', 'status', 'views', 'fb_image'], 'integer'],
            [['description', 'seo_title', 'seo_description', 'seo_keyword', 'fb_title', 'fb_description'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
        ];
    }

    function getSeoPost() {
        $taxonomy = Taxonomy::findOne(['table_name' => Posts::tableName(), 'type' => \common\func\StaticDefine::$SEO_BAI_VIET, 'table_id' => $this->id]);
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

    public function Xoa() {
        PostRelationships::deleteAll(['post_id' => $this->id, 'post_table' => Posts::tableName()]);
        $taxonomy = Taxonomy::findOne(['table_name' => Posts::tableName(), 'type' => \common\func\StaticDefine::$SEO_BAI_VIET, 'table_id' => $this->id]);
        if ($taxonomy) {
            $taxonomy->delete();
        }
        $this->delete();
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'description' => 'Mô tả',
            'post_order' => 'Post Order',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'slug' => 'Slug',
            'seo_title' => "Seo Title",
            'seo_description' => "Seo Description",
            'seo_keyword' => "Keyword",
            'fb_title' => "Facebook Title",
            'fb_description' => 'FaceBook Description',
            'fb_image' => 'Ảnh FaceBook'
        ];
    }

}
