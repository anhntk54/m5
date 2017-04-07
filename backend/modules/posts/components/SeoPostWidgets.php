<?php
namespace backend\modules\posts\components;

use yii\base\Widget;

class SeoPostWidgets extends Widget{
    public $model;
    public $form;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('seo_post',['form'=>  $this->form,'model'=>  $this->model]);
    }
}
?>

