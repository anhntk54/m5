<?php

namespace common\models;
use common\func\FunctionCommon;

use Yii;

/**
 * This is the model class for table "m5_map".
 *
 * @property integer $id
 * @property integer $m5_give_id
 * @property integer $m5_take_id
 * @property integer $member_id
 * @property integer $cronjob_id
 * @property integer $member_action
 * @property double $money
 * @property integer $status
 * @property integer $result
 * @property string $create_at
 */

/**
 * m5_give_id la id của  m5 gửi tiền
 * m5_take_id là id của m5 nhận tiền
 * member_id là id của member nhận tiền
 * member_action là id của member gửi tiền
 */
class M5Map extends \yii\db\ActiveRecord {
    const BEGIN_CODE = 1000;
    const STATUS_PENDING = 0; //người gửi tiền chưa gửi
    const STATUS_PENDING_SEND = 1; // người gửi tiền đã gửi, và chờ xác nhận
    const STATUS_COMPLETE = 2; // người nhận tiền xác nhận và hoàn thành giao dịch
    const RESULT_SUCCESS = 5;
    const RESULT_FAIL_GIVE = 2;
    const RESULT_FAIL_TAKE = 3;
    const RESULT_VIEW = 1;
    const RESULT_START = 0;
    const VIEW_START = 0;
    const VIEW_END = 1;

    public static function getTextViews() {
        return [
            self::VIEW_START => "Chưa hiển thị",
            self::VIEW_END => "Hiển thị",
        ];
    }

    public static function getTextResult() {
        return [
            self::RESULT_START => "Chưa giao dịch",
            self::RESULT_VIEW => "Đang giao dịch",
            self::RESULT_FAIL_GIVE => "Lỗi người PD",
            self::RESULT_FAIL_TAKE => "Lỗi người GD",
            self::RESULT_SUCCESS => "Thành công",
        ];
    }

    public function getCronText() {
        if ($this->cron) {
            if ($this->cron->status != CronJob::STATUS_START) {
                return "Đã chạy";
            }
        }
        return "Chưa chạy";
    }
    function getId(){
        return "PD-".(self::BEGIN_CODE + $this->id);
    }
    public function isNotRunCron() {
        if ($this->cron && $this->cron->status == CronJob::STATUS_START) {
            $date = $this->cron->date_end;
            $now = date('Y-m-d H:i:s');
            if (strtotime($now) > strtotime($date)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'm5_map';
    }

    function getM5give() {
        return $this->hasOne(M5::className(), ['id' => 'm5_give_id']);
    }

    function getM5take() {
        return $this->hasOne(M5::className(), ['id' => 'm5_take_id']);
    }

    function getReports() {
        return $this->hasMany(Report::className(), ['m5map_id' => 'id']);
    }

    function getReport($type = Report::TYPE_SEND) {
        return $this->hasOne(Report::className(), ['m5map_id' => 'id'])->where(['type' => $type]);
    }

    function getCron() {
        return $this->hasOne(CronJob::className(), ['id' => 'cronjob_id']);
    }

    function getMembergive() {
        return $this->hasOne(Member::className(), ['id' => 'member_action']);
    }

    function getMembertake() {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }

    public function setCron($str = 'm5_time_report') {
        $time = Config::getValueConfig($str);
        $date = date('d-m-Y H:i:s');
        $date1 = date('d-m-Y H:i:s', strtotime("+$time " . Config::getValueConfig('type_add_time'), strtotime($date)));
        $cronjob = CronJob::create($this->id, self::tableName());
        $this->cronjob_id = $cronjob->id;
        Cron::setCronRun($date1, $cronjob);
        $this->viewed = self::VIEW_END;
        $this->date_end = date('Y-m-d H:i:s', strtotime($date1));
        $this->save();
    }

    public static function createM5Map($money, $member_action, $member_id, $take_id, $give_id, $timeCron = '') {
        $m1 = new M5Map;
        $m1->member_action = $member_action;
        $m1->member_id = $member_id;
        $m1->money = $money;
        $m1->m5_give_id = $give_id;
        $m1->m5_take_id = $take_id;
        if ($m1->save() && $timeCron != '') {
            $m1->setCron($timeCron);
        }
        return $m1;
    }

    public function getDate() {
        if ($this->result > 0) {
            return -1;
        }
        $date = $this->date_end;
        $s = date('s', strtotime($date));
        if ($s <= 5) {
            $date = date('Y-m-d H:i:s', strtotime("+20 seconds ", strtotime($date)));
        }
        $now = date('Y-m-d H:i:s');
        if ((strtotime($date) - strtotime($now) <= 0)) {
            $date = -1;
        }else{
            $date = date('m/d/Y H:i:s',strtotime($date));
        }
        return $date;
    }

    public function getTimeEnd() {
        if ($this->result > self::RESULT_VIEW) {
            return Yii::t('app', 'TIME_M5_FINSH');
        }
        $date = $this->date_end;
        if ($this->date_end == NULL) {
            return Yii::t('app', 'DATE_END_NOT_RUN');
        }
        $s = date('s', strtotime($date));
        if ($s <= 5) {
            $date = date('Y-m-d H:i:s', strtotime("+20 seconds ", strtotime($date)));
        }
        $rem = strtotime($date) - time();
        if ($rem < 0) {
            return Yii::t('app', 'TIME_M5_FINSH');
        }
        $day = floor($rem / 86400);
        $hr = floor(($rem % 86400) / 3600);
        $min = floor(($rem % 3600) / 60);
        $sec = ($rem % 60);
        $t = '';
        if ($day)
            $t = "$day: ";
        $t.= $hr < 10 ? "0$hr:" : "$hr:";
        $t .=$min < 10 ? "0$min:" : "$min:";
        $t .=$sec < 10 ? "0$sec" : "$sec";
        return $t;
    }

    public function EndTime() {
        $member_give = $this->membergive;
        $isGiveSuccess = 0;
        if ($member_give) {
            $report = Report::find()->where(['member_id' => $member_give->id, 'result' => Report::RESULT_START])->andFilterWhere(['or', ['type' => Report::TYPE_SEND], ['type' => Report::TYPE_NOT_ACCEPT]])->one();
            if ($report) {
                $isGiveSuccess = 1;
            }
        }
        if ($isGiveSuccess == 0) {
            $this->End();
        } else {
            $this->Finish(TRUE);
        }
    }
    public function endReport() {
        foreach ($this->reports as $value) {
            $value->result = Report::RESULT_SUCCESS;
            $value->save();
        }
    }
    /*
     * Kiểm tra đã kết thúc hay chưa, đến thời gian chạy cron
     */

    // Ở đây sẽ tìm xem nếu người PD có đời F1 thì cho người hỗ trợ gửi tiền và ban người chơi này
    // CHỉ tìm đời cha của thằng PD lần đầu tiên, nếu k tìm người khác
    // Nếu không có thì sẽ tìm người chơi khác thay thế và nếu chưa tìm được thì đưa vào hàng đợi cron
    public function End() {
        $give = $this->m5give;
        $this->result = self::RESULT_FAIL_GIVE;
        $this->date_status = date('Y-m-d H:i:s');
        $title = \Yii::t('app', 'LOGS_FAIL_PD_END');
        Logs::create($this->membergive->id, $this->id, $this->tableName(), $title, $this->membergive->id);
        $link = Yii::$app->urlManager->createAbsoluteUrl(['/M5/m5map/view', 'id' => $this->id]);
        $title = "Giao dịch PD của bạn đã kết thúc bạn đã phải chịu phạt của hệ thống";
        $title .= "<br> Bạn kiểm tra giao dịch của bạn bằng link sau:<a href='$link'>Kiểm tra giao dịch</a>";
        if (Config::isSendMail()) {
            Email::create($this->membergive->email, "Giao dịch kết thúc", $title);
        }
        $this->endReport();
        if ($give) {
            $member = $give->member;
            $give->status = M5::STATUS_GIVE_NOT_COMPLETE;
            $give->save();
            if ($member) {
                if ($give->parent_id === 0 && $member->parent) {
                    $parent = $member->parent;
                    $map = $parent->createSupportMemberChild($this);
                    if ($map) {
                        $title = sprintf(\Yii::t('app', 'LOGS_CREATE_PD_CHANGE'),$member->getDisplayName());
                        Logs::create($member->parent->id, $map->id, $map->tableName(), $title, $member->parent->id);
                        $link = Yii::$app->urlManager->createAbsoluteUrl(['/M5/m5map/view', 'id' => $map->id]);
                        $title = "Bạn phải thực hiện giao dịch PD cho người chơi  " . $member->getDisplayName() . " vì đã không thực hiện đúng giao dịch";
                        $title .= "<br> Bạn kiểm tra giao dịch của bạn bằng link sau:<a href='$link'>Kiểm tra giao dịch</a>";
                        if (Config::isSendMail()) {
                            Email::create($member->parent->email, "Bắt đầu giao dịch", $title);
                        }
                        $title = sprintf(\Yii::t('app', 'LOGS_CREATE_GD_CHANGE'),$parent->getDisplayName(),  FunctionCommon::formatMoney($map->money),$member->getDisplayName());
                        Logs::create($this->membertake->id, $map->id, $map->tableName(), $title, $member->parent->id);
                        $title = "Người chơi  " . $parent->getDisplayName() . " sẽ thực hiện giao dịch với số tiền là:" . FunctionCommon::formatMoney($map->money). " cho bạn để thay thế cho người chơi " . $member->getDisplayName() . ".";
                        $title .= "<br> Bạn kiểm tra giao dịch của bạn bằng link sau:<a href='$link'>Kiểm tra giao dịch</a>";
                        if (Config::isSendMail()) {
                            Email::create($this->membertake->email, "Bắt đầu giao dịch", $title);
                        }
                    }
                } else {
                    $m5 = $this->m5take;
                    if ($m5) {
                        $m5->addTimeEnd();
                        $m5->status = M5::STATUS_ACTIVE;
                        $m5->money_current += $give->money;
                        $m5->save();
                        $title= sprintf(\Yii::t('app', 'LOGS_CREATE_PENDING_CHANGE'),$member->getDisplayName());
                        Logs::create($this->membertake->id, $m5->id, $m5->tableName(), $title, $this->membertake->id);
                        $m5->setMemberGive($m5->member_id);
                    }
                }
                Punish::create($member, $this);
                //ban thằng member
            }
        }
        $this->save();
    }

    // gọi đến khi hoàn thành một quá trính
    public function Finish($isReport = FALSE) {
        $this->status = static::STATUS_COMPLETE;
        $this->result = self::RESULT_SUCCESS;
        $this->date_status = date('Y-m-d H:i:s');
        $this->save();
        $this->m5give->checkFinish();
        $this->m5take->checkFinish();
        $cron = $this->cron;
        if ($cron) {
            $cron->Finish();
        }
        LogsMember::create($this->id,$this->tableName(),$this->member_id,Yii::t('app','LOGS_MEMBER_M5_MAP_SUCCESS'));
        LogsMember::create($this->id,$this->tableName(),$this->member_action,Yii::t('app','LOGS_MEMBER_M5_MAP_SUCCESS'));
        $link = Yii::$app->urlManager->createAbsoluteUrl(['/M5/m5map/view', 'id' => $this->id]);
        $title = "Giao dịch đã thực hiện thành công.<br> Bạn kiểm tra giao dịch của bạn bằng link sau:<a href='$link'>Kiểm tra giao dịch</a>";
        if (Config::isSendMail()) {
            Email::create($this->membergive->email, "Giao dịch thành công", $title);
            Email::create($this->membertake->email, "Giao dịch thành công", $title);
        }
        if ($isReport) {
            // xảy ra khi thằng PD đã gửi tiền mà thằng GD chưa xác nhận thì kết thúc cho thằng PD và ban thằng Gd
            $member = $this->membertake;
            if ($member) {
                Punish::create($member, $this);
            }
        }
        $this->endReport();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['m5_give_id', 'm5_take_id', 'member_id', 'member_action', 'result', 'status'], 'integer'],
            [['money'], 'number'],
            [['create_at'], 'safe']
        ];
    }

    public function getStatusText() {
        $status = $this->getStatus();
        $statusText = Yii::t('app', 'M5_MAP_STATUS_NOT_SEND_MONEY');
        if ($status == -1) {
            $statusText = Yii::t('app', 'M5_MAP_STATUS_FINISH');
        }
        if ($status == 1) {
            $statusText = Yii::t('app', 'M5_MAP_STATUS_REPORT_SEND_MONEY');
        }
        if ($status == 4) {
            $statusText = Yii::t('app', 'M5_MAP_STATUS_REPORT_RECEIVE_MONEY');
        }
        if ($status == 3) {
            $statusText = Yii::t('app', 'M5_MAP_STATUS_ENDED_SEND_MONEY');
        }
        if ($status == 5) {
            $statusText = Yii::t('app', 'M5_MAP_STATUS_END_FINISH');
        }
        return $statusText;
    }

    public function getStatus() {
        $user_id = Yii::$app->user->id;
        $member = Member::findOne($user_id);
        if ($this->result != self::RESULT_START) {
            return -1;
        }
        if ($member) {
            // nếu là người gửi tiền thì status là 0 và m
            if ($this->status == static::STATUS_PENDING) {
                if ($this->member_action === $user_id) {
                    return 1; //người gửi xác nhận gửi tiền
                }
                if ($this->member_id == $user_id) {
                    return 2; //người nhận chưa nhận được tiền
                }
            }
            if ($this->status == static::STATUS_PENDING_SEND) {
                if ($this->member_action === $user_id) {
                    return 3; //người gửi đã xác nhận gửi tiền
                }
                if ($this->member_id == $user_id) {
                    return 4; //người nhận chưa xác nhận được tiền
                }
            }
            if ($this->status == static::STATUS_COMPLETE) {
                return 5; //hoàn thành giao dịch
            }
        }
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'm5_give_id' => Yii::t('app', 'M5 Give ID'),
            'm5_take_id' => Yii::t('app', 'M5 Take ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'member_action' => Yii::t('app', 'Member Action'),
            'money' => Yii::t('app', 'Money'),
            'status' => Yii::t('app', 'Status'),
            'create_at' => Yii::t('app', 'Create At'),
            'date_end' => Yii::t('app', 'Date End'),
            'viewed' => Yii::t('app', 'BACKEND_M5MAP_VIEWED'),
            'result' => Yii::t('app', 'BACKEND_M5MAP_RESULT'),
            'cronjob_id' => Yii::t('app', 'BACKEND_M5MAP_CRONJOB'),
        ];
    }

}
