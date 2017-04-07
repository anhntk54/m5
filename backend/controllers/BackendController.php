<?php

namespace backend\controllers;

use yii\web\Controller;
use backend\modules\posts\models\PostRelationships;
use backend\modules\config\models\ConfigApp;
use backend\modules\posts\models\Taxonomy;
use common\models\Images;
use common\models\Category;
use common\models\Tags;
use common\func\StaticDefine;

/**
 * Site controller
 */
class BackendController extends Controller {

    public function createPosts($model, $isCategory = true, $isUseCategory = true, $isDiaDiem = TRUE) {
        if (isset($_POST['category']) && $isCategory) {
            $categorys = $_POST['category'];
            foreach ($categorys as $value) {
                $category = Category::findOne(['id' => $value]);
                if ($category) {
                    PostRelationships::setPost($category->id, $model->id, Category::tableName(), $model->tableName());
                }
            }
            if (count($categorys) > 0 && $isUseCategory) {
                $arrcategory = json_decode(ConfigApp::getValueConfig(StaticDefine::$CATEGORY_NEW_USE));
                if (count($arrcategory) == 0) {
                    $arrcategory = $categorys;
                } else {
                    $arrcategory = array_merge($arrcategory, $categorys);
                    $arrcategory = array_unique($arrcategory);
                    if (count($arrcategory) > 6) {
                        $i = count($arrcategory) - 6;
                        $arrcategory = array_splice($arrcategory, $i);
                    }
                }
                ConfigApp::setValueConfig(StaticDefine::$CATEGORY_NEW_USE, json_encode($arrcategory));
            }
        }
        if (isset($_POST['tags']) && $isCategory) {
            $tags = explode("[,]", $_POST['tags']);
            foreach ($tags as $value) {
                $tag = Tags::setTagsValue($value);
                if ($tag) {
                    PostRelationships::setPost($tag->id, $model->id, "tags", $model->tableName());
                }
            }
        }
        $fbImage = Images::findOne(['id' => $model->fb_image]);
        if ($fbImage) {
            PostRelationships::setPost($fbImage->id, $model->id, "fbimages", $model->tableName());
        }
        $jsonseo = [
            'seo_title' => $model->seo_title,
            'seo_description' => $model->seo_description,
            'seo_keyword' => $model->seo_keyword,
            'fb_title' => $model->fb_title,
            'fb_description' => $model->fb_description
        ];
        Taxonomy::setTaxonomy($model->id, $model->tableName(), StaticDefine::$SEO_BAI_VIET, json_encode($jsonseo));
        if (isset($_POST['idimage'])) {
            $idimage = $_POST['idimage'];
            $image = Images::findOne(['id' => $idimage]);
            if ($image) {
                PostRelationships::setPost($idimage, $model->id, Images::tableName(), $model->tableName());
            }
        }
    }

}
