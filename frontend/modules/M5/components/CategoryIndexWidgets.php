<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\M5\components;
use yii\base\Widget;
use Yii;
/**
 * Description of LinkSpanPager
 *
 * @author trieunhu
 */
class CategoryIndexWidgets extends Widget{
    public $category;
    public $cate;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('category_index',['cate'=>  $this->cate,'category'=>  $this->category]);
    }
}
