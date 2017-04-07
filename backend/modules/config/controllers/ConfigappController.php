<?php

namespace backend\modules\config\controllers;

use backend\modules\config\models\ConfigApp;
use common\models\Email;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\M5;
use Yii;

class ConfigappController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','begingame','check-system'],
                        'roles' => ['manageAll'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    public function actionCheckSystem(){
//        echo "http://m5.vl/uploads/images/2017/04/khuyen-mai-giam-gia-nen.jpg";
        header('Content-type: image/jpeg'); echo file_get_contents("http://m5.vl/uploads/images/2017/04/khuyen-mai-giam-gia-nen.jpg");
    }

    public function actionBegingame() {
        if (!M5::isRun()) {
            M5::STARTGAME();
        }
        return $this->goHome();
    }

    public function actionIndex() {
        $model = new ConfigApp();
        $model->baseUrl = ConfigApp::getValueConfig("baseUrl");
        $model->nameApp = ConfigApp::getValueConfig("nameApp");
        $model->m5_roses_direct = ConfigApp::getValueConfig("m5_roses_direct");
        $model->m5_roses_sytem_1 = ConfigApp::getValueConfig("m5_roses_sytem_1");
        $model->m5_roses_sytem_2 = ConfigApp::getValueConfig("m5_roses_sytem_2");
        $model->m5_roses_sytem_3 = ConfigApp::getValueConfig("m5_roses_sytem_3");
        $model->m5_roses_sytem_4 = ConfigApp::getValueConfig("m5_roses_sytem_4");
        $model->m5_roses_sytem_5 = ConfigApp::getValueConfig("m5_roses_sytem_5");
        $model->type_add_time = ConfigApp::getValueConfig('type_add_time');
        $model->m5_cycle_max = ConfigApp::getValueConfig("m5_cycle_max");
        $model->m5_cycle_min = ConfigApp::getValueConfig('m5_cycle_min');
        $model->m5_cycle_count_day = ConfigApp::getValueConfig('m5_cycle_count_day');
        $model->m5_precent = ConfigApp::getValueConfig('m5_precent');
        $model->m5_price = ConfigApp::getValueConfig('m5_price');
        $model->m5_time_pending_transaction = ConfigApp::getValueConfig('m5_time_pending_transaction');
        $model->m5_time_action_transaction = ConfigApp::getValueConfig('m5_time_action_transaction');
        $model->m5_count_pd = ConfigApp::getValueConfig('m5_count_pd');
        $model->send_mail = ConfigApp::getValueConfig('send_mail');
        $model->m5_time_pending_transaction_gd = ConfigApp::getValueConfig('m5_time_pending_transaction_gd');
        $model->create_logs_member = ConfigApp::getValueConfig('create_logs_member');
        $model->time_cron = ConfigApp::getValueConfig('time_cron');

        if ($model->load(Yii::$app->request->post())) {
            ConfigApp::setValueConfig("baseUrl", $model->baseUrl);
            ConfigApp::setValueConfig("nameApp", $model->nameApp);
            ConfigApp::setValueConfig("m5_roses_direct", $model->m5_roses_direct);
            ConfigApp::setValueConfig("m5_roses_sytem_1", $model->m5_roses_sytem_1);
            ConfigApp::setValueConfig("m5_roses_sytem_2", $model->m5_roses_sytem_2);
            ConfigApp::setValueConfig("m5_roses_sytem_3", $model->m5_roses_sytem_3);
            ConfigApp::setValueConfig("m5_roses_sytem_4", $model->m5_roses_sytem_4);
            ConfigApp::setValueConfig("m5_roses_sytem_5", $model->m5_roses_sytem_5);
            ConfigApp::setValueConfig("type_add_time", $model->type_add_time);
            ConfigApp::setValueConfig("m5_cycle_max", $model->m5_cycle_max);
            ConfigApp::setValueConfig("m5_cycle_min", $model->m5_cycle_min);
            ConfigApp::setValueConfig("m5_cycle_count_day", $model->m5_cycle_count_day);
            ConfigApp::setValueConfig("m5_precent", $model->m5_precent);
            ConfigApp::setValueConfig("m5_price", $model->m5_price);
            ConfigApp::setValueConfig("m5_count_pd", $model->m5_count_pd);
            ConfigApp::setValueConfig("send_mail", $model->send_mail);
            ConfigApp::setValueConfig("m5_time_action_transaction", $model->m5_time_action_transaction);
            ConfigApp::setValueConfig("time_cron", $model->time_cron);
            ConfigApp::setValueConfig("create_logs_member", $model->create_logs_member);
            ConfigApp::setValueConfig("m5_time_pending_transaction_gd", $model->m5_time_pending_transaction_gd);
            ConfigApp::setValueConfig("m5_time_pending_transaction", $model->m5_time_pending_transaction);
        }
        return $this->render('index', [
                    'model' => $model,
        ]);
    }

}
