<?php
namespace backend\modules\posts\components\images;

use yii\base\Widget;

class SliderImageWidgets extends Widget{
    public $model;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        $this->model = $this->model->sliders;
        return $this->render('slider_image',['model'=>  $this->model]);
    }
}
?>

