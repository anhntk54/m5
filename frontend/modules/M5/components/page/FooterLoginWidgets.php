<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\M5\components\page;
use yii\base\Widget;

/**
 * Description of LinkSpanPager
 *
 * @author trieunhu
 */
class FooterLoginWidgets extends Widget{
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        return $this->render('footer-login');
    }
}
