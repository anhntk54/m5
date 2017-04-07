<?php
namespace backend\modules\posts\components\images;

use yii\base\Widget;

class OneImageSliderWidgets extends Widget{
    public $model;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('one_image_slider',['value'=>  $this->model]);
    }
}
?>

