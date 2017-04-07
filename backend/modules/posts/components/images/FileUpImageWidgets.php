<?php
namespace backend\modules\posts\components\images;

use yii\base\Widget;

class FileUpImageWidgets extends Widget{
    public $model;
    public $title;
    public $type;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('file_up_image',['model'=>  $this->model,'title'=>  $this->title,'type'=>  $this->type]);
    }
}
?>

