<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\M5\components\logs;
use yii\base\Widget;

/**
 * Description of LinkSpanPager
 *
 * @author trieunhu
 */
class ViewOneLogsWidgets extends Widget{
    public $model;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('view_one_logs',['model'=>  $this->model]);
    }
}
