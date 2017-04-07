<?php

namespace common\models;

use yii\helpers\Url;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $type
 */
class Category extends \yii\db\ActiveRecord
{
    public $seo_title;
    public $seo_description;
    public $seo_keyword;
    public $fb_title;
    public $fb_description;
    public $fb_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }
    function getPostsChilds() {
        
    }
    function getPosts() {
        return $this->hasMany(Posts::className(), ['id' => 'post_id'])->andOnCondition(['type' => 'post'])->viaTable("post_relationships", ['table_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'category', 'post_table' => Posts::tableName()]);
                });
    }
    function getParent() {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    public function getTitle($the = '') {
        if ($the == '') {
            $link = "<a href='" . $this->getLink() . "'>$this->title</a>";
        } else {
            $link = "<$the><a href='" . $this->getLink() . "'>$this->title</a></$the>";
        }
        return $link;
    }

    public function getLink() {
        $link = Url::to(['/home/category/post', 'slug' => $this->slug]);
        return $link;
    }

    function getHinhAnhLink() {
        
    }
    function getIdChilds(){
        $arrs = [];
        if (!in_array($this->id, $arrs)) {
            $arrs[] = $this->id;
        }
        foreach ($this->childs as $value) {
            $arrs[] = $value->id;
            if (count($value->childs) > 0) {
                $arrs = array_merge($arrs,$value->getIdChilds());
            }
        }
        return $arrs;
    }


    function getSeoPost($seo = FALSE) {
        $taxonomy = Taxonomy::findOne(['table_name' => Category::tableName(), 'type' => \common\func\StaticDefine::$SEO_BAI_VIET, 'table_id' => $this->id]);
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
            if ($seo) {
                \Yii::$app->view->title = $this->title;
                \Yii::$app->view->registerMetaTag([
                    'property' => 'description',
                    'content' => $this->seo_description
                ]);
            }
        }
        if ($seo) {
            \Yii::$app->view->title = $this->title;
            \Yii::$app->view->registerMetaTag([
                'property' => 'description',
                'content' => $this->seo_description
            ]);
        }
    }

    function getFbimage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'fbimages', 'post_table' => Category::tableName()]);
                });
    }

    function getImage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'images', 'post_table' => Category::tableName()]);
                });
    }

    

    public function getCategoiesParent() {
        return \yii\helpers\ArrayHelper::map(Category::findAll("parent_id = 0"));
    }
}
