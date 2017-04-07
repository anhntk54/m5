<?php
namespace backend\modules\config\components;

use yii\base\Widget;

class AddMenuWidgets extends Widget{
    public $model;
    public $title;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
//        $type 
        return $this->render('addMenu',['data'=>  $this->model,'title'=>  $this->title]);
    }
}
?>

