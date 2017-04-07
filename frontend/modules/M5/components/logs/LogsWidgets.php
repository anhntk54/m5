<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\M5\components\logs;
use yii\base\Widget;
use common\models\Logs;
use Yii;

/**
 * Description of LinkSpanPager
 *
 * @author trieunhu
 */
class LogsWidgets extends Widget{
    public function init(){
            // add your logic here
            parent::init();
    }
    public function run(){
        $model = Logs::find()->where(['member_id'=>  Yii::$app->user->id,'type'=>  Logs::TYPE_USER]);
        $data = $model->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        $count = $model->andWhere(['is_view'=>0])->count();
        return $this->render('logs',['count'=>$count,'data'=>$data]);
    }
}
