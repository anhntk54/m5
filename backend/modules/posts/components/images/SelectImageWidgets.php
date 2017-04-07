<?php
namespace backend\modules\posts\components\images;

use yii\base\Widget;

class SelectImageWidgets extends Widget{
    public $model;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('select_image',['model'=>  $this->model]);
    }
}
?>

