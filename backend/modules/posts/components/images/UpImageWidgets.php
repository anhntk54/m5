<?php
namespace backend\modules\posts\components\images;

use yii\base\Widget;
use backend\modules\posts\models\Category;

class UpImageWidgets extends Widget{
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        $data = Category::find()->all();
        return $this->render('up_images',['data'=>$data]);
    }
}
?>

