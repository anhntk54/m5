<?php
namespace backend\modules\posts\components\images;

use yii\base\Widget;

class DetailsImageUploadWidgets extends Widget{
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('details_view_upload');
    }
}
?>

