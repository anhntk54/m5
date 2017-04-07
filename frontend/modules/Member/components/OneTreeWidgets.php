<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\Member\components;
use yii\base\Widget;

/**
 * Description of LinkSpanPager
 *
 * @author trieunhu
 */
class OneTreeWidgets extends Widget{
    public $model;
    public $count;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        $this->count++;
        $showClass = '';
        if ($this->count <= 4) {
            $showClass = "show";
        }
        return $this->render('one_tree',['model'=>  $this->model,'showClass'=>  $showClass,
            'count'=>  $this->count]);
    }
}
