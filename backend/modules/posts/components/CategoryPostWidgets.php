<?php

namespace backend\modules\posts\components;

use yii\base\Widget;
use backend\modules\posts\models\Category;
use backend\modules\config\models\ConfigApp;
use common\func\StaticDefine;

class CategoryPostWidgets extends Widget {

    public $model;
    public $type = 'posts';

    public function init() {
        // add your logic here
        parent::init();
    }

    public function run() {
        $title = "Danh mục bài viết";
        $titleTab1 = "Danh mục";
        $titleTab2 = "Mới sử dụng";
        $dataParent = Category::find()->where(['type' => $this->type])->all();
        if ($this->type == 'posts') {
            if (count($this->model->categories) == 0) {
                $data = Category::find()->where(['type' => $this->type])->all();
            } else {
                $arr = [];
                foreach ($this->model->categories as $value) {
                    $arr[] = $value->id;
                }
                $data = Category::find()->where(['NOT IN', 'id', $arr, 'type' => $this->type])->all();
            }
            $arrcategory = json_decode(ConfigApp::getValueConfig(StaticDefine::$CATEGORY_NEW_USE));
            $categoryUse = Category::find()->where(['id' => $arrcategory])->all();
            $categoriesChecks = $this->model->categories;
            return $this->render('category_post', [
                        'data' => $data,
                        'model' => $this->model,
                        'categoryUse' => $categoryUse,
                        'dataParent' => $dataParent,
                        'title' => $title,
                        'titleTab1' => $titleTab1,
                        'titleTab2' => $titleTab2,
                        'categoriesChecks' => $categoriesChecks,
                        'type' => $this->type
            ]);
        } else {
            $title = "Danh mục bất động sản";
            $titleTab1 = "Bds bán";
            $titleTab2 = "Cho thuê";
            $ban = Category::findOne(14);
            $thue = Category::findOne(15);
            $categoriesBan = $this->model->getCategoriesbds()->where(['id'=>$ban->getIdChilds()])->all();
            $categoriesThue = $this->model->getCategoriesbds()->where(['id'=>$thue->getIdChilds()])->all();
            //
            if (count($categoriesBan) == 0) {
                $dataBan = Category::find()->where(['id'=>$ban->getIdChilds()])->all();
            } else {
                $arr = [];
                foreach ($categoriesBan as $value) {
                    $arr[] = $value->id;
                }
                $dataBan = Category::find()->where(['id'=>$ban->getIdChilds()])->andWhere(['NOT IN', 'id', $arr])->all();
            }
            if (count($categoriesThue) == 0) {
                $dataThue = Category::find()->where(['id'=>$thue->getIdChilds()])->all();
            } else {
                $arr = [];
                foreach ($categoriesThue as $value) {
                    $arr[] = $value->id;
                }
                $dataThue = Category::find()->where(['id'=>$thue->getIdChilds()])->andWhere(['NOT IN', 'id', $arr])->all();
            }
            return $this->render('category_post_bds', [
                        'dataBan' => $dataBan,
                        'dataThue' => $dataThue,
                        'model' => $this->model,
                        'dataParent' => $dataParent,
                        'title' => $title,
                        'titleTab1' => $titleTab1,
                        'titleTab2' => $titleTab2,
                        'categoriesBan' => $categoriesBan,
                        'categoriesThue' => $categoriesThue,
                        'type' => $this->type
            ]);
        }
    }

}
?>

