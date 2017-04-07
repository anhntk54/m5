<?php

namespace backend\modules\posts\components;

use yii\base\Widget;
use yii\helpers\Url;

class CreatePostWidgets extends Widget {

    public $model;
    public $form;

    public function init() {
        // add your logic here
        parent::init();
    }

    public function run() {
        if ($this->model->isNewRecord) {
            $this->model->status = 5;
        }
        $link = Url::to("?r=batdongsan/default/xoa&id=".  $this->model->id);
        if ($this->model->tableName() == "posts") {
            $link = Url::to("?r=posts/default/xoa&id=".  $this->model->id);
        }
        return $this->render('create_post', ['model' => $this->model,'form'=>  $this->form,'link'=>$link]);
    }

}
?>

