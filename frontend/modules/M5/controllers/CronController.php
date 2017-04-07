<?php

namespace frontend\modules\M5\controllers;

use common\models\LogsMember;
use common\models\Member;
use common\models\M5;
use common\models\Cron;
use common\models\Logs;

class CronController extends \yii\web\Controller {

    /**
     * Link này chạy tự động hàng giờ
     * Tạo đăng ký nhận tiền tự động cho người dùng
     * 1. Tìm những hành động gửi tiền đã hoàn thành việc gửi tiền
     *    - Tìm kiếm các hành động gửi tiền thành công
     *    - Xét người cho tiền vào trạng thái nhận tiền và kết thúc hành động cho tiền của người đó
     *    - Bắt đầu trạng thái nhận cho người đó
     */
    public function actionIndex() {
        LogsMember::create(1000,"logs",123,"Chạy tự động");
        if (M5::isRun()) {
            $members = Member::find()->where(['role_id' => Member::ROLE_TAKE])->all();
            foreach ($members as $value) {
                $value->createM5Give();
            }
        }
//        $listGive = M5::find()->where(['status' => M5::STATUS_END, 'type' => M5::TYPE_GIVE])->all();
//        foreach ($listGive as $value) {
////            die("2");
//            $value->createActionTake();
//        }

        $listTakes = M5::find()->where(['>','money_current',0])->andWhere(['!=','type',  M5::TYPE_GIVE])->all();
        foreach ($listTakes as $value) {
//            die("31");
            $value->setMemberGive($value->member_id);
        }
    }

    /**
     * Hẹn giờ để chạy sau khi chạy xong xóa cronjob
     * 1. Chạy lúc hết thời gian để gửi tiền đi
     * 2. Chạy khi người chơi nhận tiền về
     * 3. check người dùng chưa đáp ứng yêu cầu thi ban người dùng
     */
    public function actionCheck($id,$code) {
        $model = Cron::findOne(['id'=>$id,'code'=>$code]);
        Logs::create($id, 10000, "test", "chay thang $id",0,Logs::TYPE_SYSTEM);
        if ($model && $model->status == Cron::STATUS_RUN) {
            $model->run();
            
        }
    }

    public function actionTest() {
        $cron = new \yii2tech\crontab\CronTab();
        $cron->removeAll();
    }

}
