<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\M5\components;
use yii\base\Widget;
use common\models\Member;
use common\models\M5;
use common\models\M5Map;
use Yii;
/**
 * Description of LinkSpanPager
 *
 * @author trieunhu
 */
class HomeTableWidgets extends Widget{
    public $type;
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        $limit = 10;
        $member = Member::findOne(Yii::$app->user->id);
        $data = [];
        if ($this->type == M5::TYPE_GIVE) {
            $data = M5Map::find()->leftJoin('m5','m5.id = m5_map.m5_give_id ')->where(['m5_map.member_action'=>$member->id,'m5.type'=>  $this->type])->limit($limit)->all();
        }  else {
            if ($this->type == M5::TYPE_TAKE_ROSES) {
                $data = M5Map::find()->leftJoin('m5','m5.id = m5_map.m5_take_id ')->where(['m5_map.member_id'=>$member->id,'m5.type'=>  $this->type])->limit($limit)->all();
            }  else {
                $data = M5Map::find()->leftJoin('m5','m5.id = m5_map.m5_take_id ')->where(['m5_map.member_id'=>$member->id])->andWhere(['!=','m5.type',  M5::TYPE_GIVE])->andWhere(['!=','m5.type',  M5::TYPE_TAKE_ROSES])->limit($limit)->all();
//                die(var_dump($data));
            }
        }
        return $this->render('home_table',['member'=>$member,'model'=>$data,'type'=>  $this->type]);
    }
}
