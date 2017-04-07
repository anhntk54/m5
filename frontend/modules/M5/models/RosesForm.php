<?php

namespace frontend\modules\M5\models;

use common\models\Transactions;
use common\models\Roses;
use common\models\Member;
use common\models\Config;
use common\models\M5;
use common\models\Logs;
use Yii;
use common\models\LogsMember;
/**
 * Signup form
 */
class RosesForm extends Roses {

    public $count_pin;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['money', 'checkValidate']
        ];
    }

    public function checkValidate($attribute, $params) {
        $model = Member::findOne(Yii::$app->user->id);
        if (!M5::isRun()) {
            $this->addError($attribute, \Yii::t('app', 'GIVE_FORM_ERROR_NOT_GAME_START'));
        }
        if ($model) {
            if ($model->role_id == Member::ROLE_DISABLE) {
                $this->addError($attribute, \Yii::t('app', 'GIVE_FORM_ERROR_USER_BLOCK'));
            }
            if ($model->pin == 0) {
                $this->addError($attribute, Yii::t('app', 'COUNT_PIN_ERROR'));
            }
            $money = Config::getValueConfig('m5_price');
            if ($money > $model->money_roses) {
                $this->addError($attribute, Yii::t('app', 'ROSES_CREATE_FAIL_MIN'));
            }
            $count = Transactions::getCountOfWeek($model);
            if ($model->level && $count >= $model->level->count_roses) {
                $this->addError($attribute, Yii::t('app', 'ROSES_CREATE_FAIL_MAX_OFWEEK'));
            }
        }
    }

    public function saveData() {
        //sau khi đăng ký cho tiền sẽ hẹn giờ để nhận được người nhận tiền của mình
        $model = Member::findOne(Yii::$app->user->id);
        if ($model) {
            $money = Config::getValueConfig('m5_price');
            $m5 = M5::createM5($money, $money, $model->id, M5::TYPE_TAKE_ROSES, M5::STATUS_ACTIVE, 0);
            if ($m5) {
                $model->setPin();
                $model->money_roses -= $money;
                $model->save();
                $roses = Transactions::create($model->id, $m5->id, $m5->tableName(), 0, $money, Transactions::TYPE_ROSES);
                if ($roses) {
                    $title = \Yii::t('app', 'LOGS_CREATE_ROSER_GD');
                    Logs::create($model->id, $roses->id, $roses->tableName(), $title);
                    LogsMember::create($roses->id,$roses->tableName(),$model->id,Yii::t('app','LOGS_MEMBER_ROSERS_CREATE'));
                }
                $m5->setMemberGive($model->id);
                return true;
            }
        }
        return FALSE;
    }

}
