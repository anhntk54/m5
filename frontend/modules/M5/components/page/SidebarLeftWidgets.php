<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\M5\components\page;
use yii\base\Widget;
use common\models\Member;
/**
 * Description of LinkSpanPager
 *
 * @author trieunhu
 */
class SidebarLeftWidgets extends Widget{
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        $member = Member::findOne(\Yii::$app->user->id);
        return $this->render('siderbar_left',['member'=>$member]);
    }
}
