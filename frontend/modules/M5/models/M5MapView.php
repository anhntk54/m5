<?php

namespace frontend\modules\M5\models;

use common\models\M5Map;
use common\models\Report;
use Yii;
use common\models\Logs;
use common\models\Member;
use common\func\FunctionCommon;
use common\models\LogsMember;
/**
 * Signup form
 */
class M5MapView extends M5Map {

    public $report;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['report'], 'integer'],
            ['money', 'checkValidate']
        ];
    }

    public function checkValidate($attribute, $params) {
        $model = Member::findOne(Yii::$app->user->id);
        if ($model) {
        }
    }

    public function checkCreateReport() {
        $status = $this->getStatus();
        $user_id = Yii::$app->user->id;
        
        if ($this->member_action == $user_id) {
//            die("aksjjs".$status);
            if ($status == 3) {
                $report = Report::findOne(['m5map_id' => $this->id, 'type' => Report::TYPE_NOT_ACCEPT]);
                if (!$report) {
                    return TRUE;
                }
            }
        } else {
            if ($status == 2) {
                
                $report = Report::findOne(['m5map_id' => $this->id, 'type' => Report::TYPE_NOT_SEND]);
                if (!$report) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /*
     *
     */

    public function saveData() {
        $statusForm = $this->getStatus();
        if ($this->report == 0) {
            if ($statusForm == 1) {
                $this->status = static::STATUS_PENDING_SEND;
                $report = Report::findOne(['m5map_id' => $this->id, 'type' => Report::TYPE_NOT_SEND]);
                if ($report) {
                    $report->result = Report::RESULT_SUCCESS;
                    $report->save();
                }
                //ở đây tạo một report đã gửi tiền. nếu đến thời gian mà người GD chưa xác nhận thì xác nhận đã chuyển tiền
                Report::setReport($this->id, $this->member_action);
                $money = $this->money;
                $title = sprintf(Yii::t('app', 'LOGS_SEND_MONEY_PD'), $this->membergive->getDisplayName(), FunctionCommon::formatMoney($money), $this->membertake->getDisplayName());
                Logs::create($this->member_id, $this->id, $this->tableName(), $title, $this->member_action);
                LogsMember::create($this->id,$this->tableName(),$this->member_action,Yii::t('app','LOGS_MEMBER_M5_MAP_SEND_MONEY'));
            }
            if ($statusForm == 4) {
                $this->Finish();
                 $report = Report::findOne(['m5map_id' => $this->id, 'type' => Report::TYPE_NOT_ACCEPT]);
                if ($report) {
                    $report->result = Report::RESULT_SUCCESS;
                    $report->save();
                }
                $money = $this->money;
                LogsMember::create($this->id,$this->tableName(),$this->member_id,Yii::t('app','LOGS_MEMBER_M5_MAP_ACCEPT_MONEY'));
                $title = sprintf(\Yii::t('app', 'LOGS_REPORT_OK_SEND_MONEY'),$this->membertake->getDisplayName(),  FunctionCommon::formatMoney($money));
                Logs::create($this->member_action, $this->id, $this->tableName(), $title, $this->member_id);
                // check xem quá trình cho của người cho kết thúc hay chưa
            }
        } else {
            //có 2 trạng thái report ở đây người PD report đã chuyển tiền và người GD chưa nhận được tiền
            //Nếu 
            
            $isCreate = $this->checkCreateReport();
            // Nếu người dùng chưa gửi tiên
            if ($statusForm == 2 && $isCreate) {
                $re = Report::setReport($this->id, $this->member_id, Report::TYPE_NOT_SEND);
                $title = sprintf(\Yii::t('app', 'LOGS_REPORT_TAKE_NOT_SEND'),$this->membertake->getDisplayName());
                Logs::create($this->member_action, $re->id, $re->tableName(), $title, $this->member_id);
                LogsMember::create($this->id,$this->tableName(),$this->member_id,Yii::t('app','LOGS_MEMBER_M5_MAP_REPORT_SEND_MONEY'));
                
            }
            if ($statusForm == 3 && $isCreate) {
                $re = Report::setReport($this->id, $this->member_action, Report::TYPE_NOT_ACCEPT);
                $title = sprintf(\Yii::t('app', 'LOGS_REPORT_GIVE_NOT_ACCEPT'),$this->membergive->getDisplayName());
                Logs::create($this->member_id, $re->id, $re->tableName(), $title, $this->member_action);
                LogsMember::create($this->id,$this->tableName(),$this->member_action,Yii::t('app','LOGS_MEMBER_M5_MAP_REPORT_ACCEPT_MONEY'));
            }
        }
        return $this->save();
    }

}
