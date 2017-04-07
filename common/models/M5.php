<?php

namespace common\models;
use common\func\FunctionCommon;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "m5".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $member_id
 * @property string $type
 * @property double $money
 * @property string $created_at
 * @property integer $pending
 * @property integer $status
 */
// type = give cho tiền
// type = take nhận tiền vào hệ thống
// status:0 là bắt đầu, 1 là đang sử dụng, 3 là kết thúc
class M5 extends ActiveRecord {

    const PENDING_START = 0;
    const PENDING_RUN = 1;
    const PENDING_TRASACTION = 2;
    const TIME_PENDING = 'm5_time_pending_transaction';
    const TIME_PENDING_GD = 'm5_time_pending_transaction_gd';
    const TIME_ACTION = 'm5_time_action_transaction';
    const TYPE_GIVE = "give";
    const TYPE_TAKE = "take";
    const TYPE_TAKE_USER = "take_user";
    const TYPE_TAKE_MEMBER_AUTO = "take_member_auto";
    const TYPE_TAKE_ROSES = "take_roses";
    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1; // đang trong quá trình cho tiền
    const STATUS_TAKE = 2; //đã tìm được người giao dịch
    const STATUS_TAKE_LIST = 3; //Đã tìm được hết người nhận tiền của người cho tiền
    const STATUS_GIVE_NOT_COMPLETE = -1; //Khi một lần cho đã quá thời gian
    const STATUS_END = 5; //kết thúc
    const STATUS_FINISH = 6; //kết thúc một quá trình PD và đã đăng ký nhận tiền cho người này
    const VIEW_START = 0; //khi trong quá trình đang chờ không được xem các giao dịch của mình
    const VIEW_END = 1; //đã hết thời gian chờ

    public function getStatus() {
        $text = '';
        if ($this->pending == self::PENDING_RUN) {
            return Yii::t('app', 'SATTUS_M5_PENDDING_RUN');
        }
        if ($this->type == self::TYPE_GIVE) {
            switch ($this->status) {
                case self::STATUS_ACTIVE:
                    $text = $this->viewed == self::VIEW_END ? Yii::t('app', 'SATTUS_M5_SEND_ONE_MONEY') : Yii::t('app', 'SATTUS_M5_SEND_NOT_EXIST_LIST_MONEY');
                    break;
                case self::STATUS_TAKE:
                    $text = Yii::t('app', 'SATTUS_M5_SENDING_MONEY');
                    break;
                case self::STATUS_TAKE_LIST:
                    $text = Yii::t('app', 'SATTUS_M5_SENDING_MONEY');
                    break;
                case self::STATUS_GIVE_NOT_COMPLETE:
                    $text = Yii::t('app', 'SATTUS_M5_NOT_SUCCESSFULL');
                    break;
                case self::STATUS_END:
                    $text = Yii::t('app', 'SATTUS_M5_SUCCESSFULL');
                    break;
                case self::STATUS_FINISH:
                    $text = Yii::t('app', 'SATTUS_M5_FINSH');
                    break;
                default:
                    # code...
                    break;
            }
        } else {
            switch ($this->status) {
                case self::STATUS_ACTIVE:
                    $text = Yii::t('app', 'SATTUS_M5_GIVE_FINDING');
                    break;
                case self::STATUS_TAKE:
                    $text = Yii::t('app', 'SATTUS_M5_GIVE_SEND');
                    break;
                case self::STATUS_TAKE_LIST:
                    $text = Yii::t('app', 'SATTUS_M5_GIVE_SEND');
                    break;
                case self::STATUS_GIVE_NOT_COMPLETE:
                    $text = Yii::t('app', 'SATTUS_M5_NOT_SUCCESSFULL');
                    break;
                case self::STATUS_END:
                    $text = Yii::t('app', 'SATTUS_M5_SUCCESSFULL');
                    break;
                case self::STATUS_FINISH:
                    $text = Yii::t('app', 'SATTUS_M5_FINSH');
                    break;
                default:
                    # code...
                    break;
            }
        }
        return $text;
    }

    public function getTimeEnd() {
        if ($this->pending == self::PENDING_TRASACTION && $this->date_end == null) {
            return Yii::t('app', 'TIME_M5_PENDING');
        }
        $date = $this->date_pending;
        if ($this->viewed == self::VIEW_END) {
            $date = $this->date_end;
        }
        if ($this->pending == self::PENDING_RUN) {
            $date = $this->date_pending;
        }
        $s = date('s', strtotime($date));
        if ($s <= 5) {
            $date = date('Y-m-d H:i:s', strtotime("+20 seconds ", strtotime($date)));
        }
        $rem = strtotime($date) - time();
        if ($this->status >= self::STATUS_END) {
            return Yii::t('app', 'TIME_M5_FINSH');
        }
        if ($this->status == self::STATUS_GIVE_NOT_COMPLETE) {
            $rem = -1;
        }
        if ($rem < 0) {
            return Yii::t('app', 'TIME_M5_FINSH');
        }
        $day = floor($rem / 86400);
        $hr = floor(($rem % 86400) / 3600);
        $min = floor(($rem % 3600) / 60);
        $sec = ($rem % 60);
        $t = '';
        if ($day)
            $t = "$day days ";
        $t.= $hr < 10 ? "0$hr:" : "$hr:";
        $t .=$min < 10 ? "0$min:" : "$min:";
        $t .=$sec < 10 ? "0$sec" : "$sec";
        return $t;
    }

    public static function getTypes() {
        return[
            self::TYPE_GIVE => 'Giao dịch PD',
            self::TYPE_TAKE => 'Giao dịch GD',
            self::TYPE_TAKE_USER => 'Được nhận tiền PD',
            self::TYPE_TAKE_ROSES => 'Nhận hoa hồng',
            self::TYPE_TAKE_MEMBER_AUTO => 'Nhận tiền thay thế',
        ];
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
    public function isCreateMemberTake() {
        if ($this->type == self::TYPE_GIVE && $this->money_current > 0 && $this->status != self::STATUS_GIVE_NOT_COMPLETE) {
            return TRUE;
        }
        return FALSE;
    }
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'm5';
    }
    function getMember() {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }

    function getGives() {
        return $this->hasMany(M5Map::className(), ['m5_give_id' => 'id']);
    }

    function getTakes() {
        return $this->hasMany(M5Map::className(), ['m5_take_id' => 'id']);
    }

    function getCron() {
        return $this->hasOne(CronJob::className(), ['id' => 'cronjob_id']);
    }

    function getParent() {
        return $this->hasOne(M5::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        ];
    }

    public function getMoneyTake() {
        $money = $this->money;
        $percent = 1 / Config::getValueConfig('m5_precent');
        return $money * ($percent + 1);
    }

    public static function createM5($money, $moneyTake, $member_id, $type, $status, $parent_id,$time_run = 0) {
        $model = new M5;
        $model->cycle_id = Cycle::current()->id;
        $model->parent_id = $parent_id;
        $model->type = $type;
        $model->status = $status;
        $model->member_id = $member_id;
        $model->money = $money;
        $model->money_current = $moneyTake;
        $model->save(FALSE);
        if ($model && $time_run == 0) {
            $model->addTimeEnd();
        }
        return $model;
    }

    public function getDate() {
        $date = $this->date_pending;
        if ($this->pending == self::PENDING_START) {
            $date = $this->date_end;
        }
        if ($this->status >= self::STATUS_END || $this->pending == self::PENDING_TRASACTION) {
            return -1;
        }
        $s = date('s', strtotime($date));
        if ($s <= 5) {
            $date = date('m/d/Y H:i:s', strtotime("+20 seconds ", strtotime($date)));
        }
        $now = date('Y-m-d H:i:s');
        if ((strtotime($date) - strtotime($now) <= 0)) {
            $date = -1;
        }else{
            $date = date('m/d/Y H:i:s',strtotime($date));
        }

        return $date;
    }

    /*
      - Phải check xem đã tạo m5 take chưa nếu tồn tại chuyền model đó
     */

    public function createActionTake() {

        $moneyTake = $this->getMoneyTake();
        $model = self::createM5($moneyTake, $moneyTake, $this->member_id, self::TYPE_TAKE, self::STATUS_ACTIVE, $this->id);
        $fomartMoney = FunctionCommon::formatMoney($moneyTake);
        $title = sprintf(\Yii::t('app', 'LOGS_REGISTER_GD'),  $fomartMoney);
        Logs::create($this->member_id, $model->id, $model->tableName(), $title, 0, Logs::TYPE_SYSTEM);
        $title = sprintf(\Yii::t('app', 'LOGS_MEMBER_M5_CREATE_GD'),  $fomartMoney);
        LogsMember::create($model->id,$model->tableName(),$this->member_id,$title);
        $model->setMemberGive($this->member_id);
    }

    // Nếu mà không tìm người cho tiền thì phải xóa model đi luôn
    public function setMemberGive($user_id) {
        $member = Member::findOne($user_id);
//        Logs::create(0,0,0," số tiền hiện tại:".$this->money_current,0);
        if (!$member || $this->money_current <= 0)
            return;
        $gives = M5::find()->where(['type' => self::TYPE_GIVE, 'status' => self::STATUS_ACTIVE])->andWhere(['!=', 'member_id', $member->id])->andWhere(['>', 'money_current', 0])->all();
        $countGive = count($gives);
        if ($countGive > 0) {
            $give = $gives[0];
            if ($give) {
                $check = 0;
                $money = $this->money_current;
                $moneyCurrent = $money;
                if ($money > $give->money_current) {
                    $money = $give->money_current;
                } else {
                    $check = 1;
                    $this->status = self::STATUS_TAKE;
                }
                $moneyCurrent -= $money;
                $give->money_current -= $money;
                $map = M5Map::createM5Map($money, $give->member_id, $member->id, $this->id, $give->id);
                $this->money_current = $moneyCurrent;
                if ($give->money_current <= 0) {
                    $give->status = self::STATUS_TAKE;
                }
                $this->save(FALSE);
                $give->save(FALSE);

                if ($moneyCurrent <= 0) {
                    return TRUE;
                } else {
                    $this->setMemberGive($user_id);
                }
            }
        }
        return TRUE;
    }

    public function sendLogsActionM5Map($give, $take) {
        $title = sprintf(\Yii::t('app', 'LOGS_M5_MAP_CREATE_GD'),$take->member->getDisplayName(),  FunctionCommon::formatMoney($this->money));
        Logs::create($this->member_id, $this->id, $this->tableName(), $title, $give->member_id);
        $link = Yii::$app->urlManager->createAbsoluteUrl(['/M5/m5map/', 'id' => $take->id]);
        $title = "Người chơi " . $give->member->getDisplayName() . " đã nhận giao dịch GD với số tiền là " . $this->money . " cho bạn";
        $title .= "<br> Bạn kiểm tra giao dịch của bạn bằng link sau:<a href='$link'>Kiểm tra giao dịch</a>";
        if (Config::isSendMail()) {
            Email::create($take->member->email, "Bắt đầu giao dịch", $title);
        }
        //give
        $title = sprintf(\Yii::t('app', 'LOGS_M5_MAP_CREATE_PD'),$give->member->getDisplayName(),  FunctionCommon::formatMoney($this->money));
        Logs::create($give->member_id, $this->id, $this->tableName(), $title, $this->member_id);
        $link = Yii::$app->urlManager->createAbsoluteUrl(['/M5/m5map/', 'id' => $give->id]);
        $title = "Người chơi <p class='name'>" . $take->member->username . "</p> nhận giao dịch PD với số tiền là " . $this->money . " đến bạn";
        $title .= "<br> Bạn kiểm tra giao dịch của bạn bằng link sau:<a href='$link'>Kiểm tra giao dịch</a>";
        if (Config::isSendMail()) {
            Email::create($give->member->email, "Bắt đầu giao dịch", $title);
        }
    }

    public function addTimeEnd($action = 0, $time = self::TIME_PENDING) {
        // Logs::create(0, 0, $this->id, "addTimeEnd $action", 0, Logs::TYPE_SYSTEM);
        if ($action == 0) {
            // Logs::create(0, 0, $this->id, "addTimeEnd", 0, Logs::TYPE_SYSTEM);
            
            if ($this->type != self::TYPE_GIVE) {
                $time = self::TIME_PENDING_GD;
            }
            $time = Config::getValueConfig($time);
            $date = date('d-m-Y H:i:s');
            $date1 = date('d-m-Y H:i:s', strtotime("+$time " . Config::getValueConfig('type_add_time'), strtotime($date)));
            $cronjob = CronJob::create($this->id, self::tableName());
            $this->cronjob_id = $cronjob->id;
            $this->pending = self::PENDING_RUN;
            Cron::setCronRun($date1, $cronjob);
            $this->date_pending = date('Y-m-d H:i:s', strtotime($date1));
            $this->save(FALSE);
        } else {

            $time = Config::getValueConfig('m5_time_action_transaction');
            $date = date('d-m-Y H:i:s');
            $date1 = date('d-m-Y H:i:s', strtotime("+$time " . Config::getValueConfig('type_add_time'), strtotime($date)));
            $isChange = 0;
            if ($this->type != self::TYPE_GIVE) {
                $data = $this->takes;

                foreach ($data as $value) {
                    $give = $value->m5give;
                    $take = $value->m5take;
//                    Logs::create(0, 0, $this->id, "addTimeEnd 1 count take " . count($data) . " time give:" . $give->date_pending . " time take:" . $take->date_pending, 0, Logs::TYPE_SYSTEM);
                    if ((strtotime($give->date_pending) <= strtotime($take->date_pending)) || $action == 2) {
                        if ($value->cronjob_id == 0) {
                            $value->setCron('m5_time_action_transaction');
                            $give->pending = self::PENDING_START;
                            $give->date_end = date('Y-m-d H:i:s', strtotime($date1));
                            $give->viewed = self::VIEW_END;
                            $give->save(FALSE);
                            $this->sendLogsActionM5Map($give, $take);
                            $this->date_end = date('Y-m-d H:i:s', strtotime($date1));
                            $this->viewed = self::VIEW_END;
                            $this->pending = self::PENDING_START;
                            $this->save(FALSE);
                        }
                    } else {
                        $take->pending = self::PENDING_TRASACTION;
                        $take->save(FALSE);
                    }
                }
            } else {
                $data = $this->gives;
                if (count($data) > 0) {
                    foreach ($data as $value) {
                        $give = $value->m5give;
                        $take = $value->m5take;
                        if (strtotime($give->date_pending) >= strtotime($take->date_pending)) {
                            if ($value->cronjob_id == 0) {
                                $value->setCron('m5_time_action_transaction');
                                $take->date_end = date('Y-m-d H:i:s', strtotime($date1));
                                $take->pending = self::PENDING_START;
                                $take->viewed = self::VIEW_END;
                                $take->save(FALSE);
                                $this->sendLogsActionM5Map($give, $take);
                                $this->date_end = date('Y-m-d H:i:s', strtotime($date1));
                                $this->viewed = self::VIEW_END;
                                $this->pending = self::PENDING_START;
                                $this->save(FALSE);
                            }
                        } else {
                            $give->pending = self::PENDING_TRASACTION;
                            $give->save(FALSE);
                        }
                    }
                } else {
                    $this->status = self::STATUS_GIVE_NOT_COMPLETE;
                    $this->pending = self::PENDING_START;
                    $this->save(FALSE);
                }
            }
        }
    }

    public function EndTime() {
        $endtime = 0;

        if ($this->type != self::TYPE_GIVE ) {
            // nếu hết thời gian chờ mà chưa có người giao dịch thì cộng thêm thời gian
            if ($this->money_current > 0){
                $this->addTimeEnd();
            }

            if (count($this->takes) > 0) {//kiểm tra đã có giao dịch thì cho giao dịch chạy
                $endtime = 1;
            }
        } else {
            if (count($this->gives) > 0){
                $endtime = 1;
            }
            if ($this->money_current > 0){
                $endtime = $this->setUserTakeGive();
            }
        }
        if ($endtime == 1) {
//            Logs::create(0, 2000, "EndTime", $this->id, Logs::TYPE_SYSTEM);
            $this->status = self::STATUS_TAKE_LIST;
            $this->addTimeEnd(1);
            $this->save();
        }
    }
    function setUserTakeGive(){
        if ($this->type == self::TYPE_GIVE && $this->money_current > 0){
            $user = Member::getMemberAutoTake();
            if ($user){
                $m5 = self::createM5($this->money_current,0,$user->id,self::TYPE_TAKE_USER,self::STATUS_TAKE,$this->id,1);
                if ($m5){
                    $m5->date_pending = date('Y-m-d H:i:s');
                    M5Map::createM5Map($this->money_current, $this->member_id, $user->id, $m5->id, $this->id);
                    $m5->addTimeEnd(2);
                    $this->money_current = 0;
                    $this->save();
                    return 1;
                }
            }
        }
        return 0;
    }
    public function isFinish() {
        $i = 0;
        if ($this->type == static::TYPE_GIVE) {
            $model = $this->gives;
        } else {
            $model = $this->takes;
        }
        foreach ($model as $value) {
            if ($value->status != M5Map::STATUS_COMPLETE) {
                $i++;
            }
        }
        return $i == 0;
    }

    /**
     * Kiểm tra quá trình cho nhận đã hoàn thành hết chưa
     */
    public function checkFinish() {
        if ($this->isFinish()) {
            $status = self::STATUS_FINISH;
            if ($this->type == static::TYPE_GIVE) {
                $member = $this->member;
                $isPunish = 0;
                if ($member) {
                    if ($member->punished) {
                        $title = \Yii::t('app', 'LOGS_FAIL_PD');
                        Logs::create($member->id, $this->id, $this->tableName(), $title);
                        $member->punished->realize();
                        $isPunish = 1;
                    }
                }
                if ($isPunish == 0){
                    $this->createActionTake();
//                    echo 'crreea';
                }
                $this->setRoses();
            } else {
                if ($this->money_current > 0) {
                    $status = self::STATUS_TAKE_LIST;
                }
                if ($this->type == self::TYPE_TAKE_ROSES) {
                    $trans = Transactions::findOne(['table_id' => $this->id, 'table_name' => self::tableName()]);
                    if ($trans) {
                        $trans->status = Transactions::SATTUS_SUCCESS;
                        $trans->save();
                    }
                }
            }
            $this->status = $status;
            $this->save();
//            die();
            return TRUE;
        }
        return FALSE;
    }

    public static function isRun() {
        $config = Config::getValueConfig('m5_run');
        if ($config) {
            return $config > 0 ? TRUE : FALSE;
        }
        return FALSE;
    }

    public static function STARTGAME() {
        if (!self::isRun()) {
            Config::setValueConfig('m5_run', 1);
            Cycle::create();
            Cron::setCronEvery();
        }
    }

    public function getValueRoses($value, $member, $id, $type = Roses::TYPE_DIRECT) {
        $money = $this->money;
        $roser_direct = Config::getValueConfig($value);
        $money_direct = $money * $roser_direct / 100;
        $member->money_roses += $money_direct;
        $member->save();
        $roses = Roses::setRoses($this->id, $member->id, $roser_direct, $type, $money_direct);
        if ($roses) {
            $memberGive = Member::findOne($id);
            $nameMember = $memberGive != NULL ? $memberGive->username : "Người dùng cấp dưới";
            $title = sprintf(\Yii::t('app', 'LOGS_CREATE_ROSER'),  FunctionCommon::formatMoney($money_direct),$nameMember);
            Logs::create($member->id, $roses->id, $roses->tableName(), $title, $id);
            $title = sprintf(\Yii::t('app', 'LOGS_MEMBER_ROSERS_RECEIVE_MONEY'),  FunctionCommon::formatMoney($money_direct));
            LogsMember::create($this->id,$this->tableName(),$member->id,$title);
        }
    }

    public function setRoses() {

        $member = Member::findOne($this->member_id);
        if ($member && $member->parent) {
            $parent = $member->parent;
            $this->getValueRoses('m5_roses_direct', $parent, $this->member_id);
            $this->setSystemRoses($parent, $this->member_id);
        }
    }

    public function setSystemRoses($member, $id, $count = 1) {
        $str = "m5_roses_sytem_$count";
        $this->getValueRoses($str, $member, $id, Roses::TYPE_SYSTEM);
        if ($member->parent) {
            $count++;
            $this->setSystemRoses($member->parent, $id, $count);
        }
    }

    //cộng lượt giao dịch cho người cha khi giao dịch lần đầu
    public function getCountM5($member) {
        if (count($member->gives) == 1) {
            $member->addCountM5();
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'type' => Yii::t('app', 'Type'),
            'money' => Yii::t('app', 'Money'),
            'created_at' => Yii::t('app', 'Created At'),
            'percent' => Yii::t('app', 'Percent'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

}
