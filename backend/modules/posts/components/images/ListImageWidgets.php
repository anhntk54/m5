<?php
namespace backend\modules\posts\components\images;

use yii\base\Widget;

class ListImageWidgets extends Widget{
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('list_image');
    }
}
?>

