<?php
namespace backend\modules\config\components;

use yii\base\Widget;

class MenuLiWidgets extends Widget{
    public $id;
    public $model;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('menu_li',['id'=>  $this->id,'model'=>  $this->model]);
    }
}
?>

