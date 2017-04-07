<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\modules\M5\components;

use yii\base\Widget;
use common\models\M5;
use common\models\Member;
use backend\modules\M5\models\CreateMemberTake;

/**
 * Description of LinkSpanPager
 *
 * @author trieunhu
 */
class CreateMemberTakeWidgets extends Widget {

    public $model;

    public function init() {
        // add your logic here
        parent::init();
    }

    public function run() {
        if ($this->model->isCreateMemberTake()) {
            $value = new CreateMemberTake;
            $value->m5_id = $this->model->id;
            $list = Member::find()->where(['status'=>  Member::STATUS_AUTO_TAKE])->all();
            return $this->render('create_member_take',['model'=>  $this->model,'value'=>$value,'list'=>$list]);
        }
    }

}
