<?php
namespace backend\modules\posts\components\images;

use yii\base\Widget;

class ImageViewPostWidgets extends Widget{
    public $image;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('image_view_upload_post',['image'=>  $this->image]);
    }
}
?>

