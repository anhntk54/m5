<?php

namespace frontend\modules\M5\models;

use common\models\Cycle;
use common\models\M5;
use common\models\Member;
use common\models\Config;
use Yii;
use common\models\LogsMember;

/**
 * Signup form
 */
class GiveForm extends M5 {

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
            if (empty($model->bank_code) || empty($model->bank_agency) || empty($model->bank_name)) {
                $this->addError($attribute, \Yii::t('app', 'GIVE_FORM_ERROR_NOT_FULL_INFO'));
            }
            if ($model->pin == 0) {
                $this->addError($attribute, Yii::t('app', 'COUNT_PIN_ERROR'));
            }
            $cycle = Cycle::current();
            if ($cycle) {
                $count = count($model->givecycle);
                if ($count >= $cycle->max) {
                    $this->addError($attribute, \Yii::t('app', 'GIVE_FORM_ERROR_MAX_PD_CYCLE'));
                }
            } else {
                $this->addError($attribute, \Yii::t('app', 'GIVE_FORM_ERROR_NOT_GAME_START'));
            }
        }
    }

    public function saveData() {
        //sau khi đăng ký cho tiền sẽ hẹn giờ để nhận được người nhận tiền của mình
        $model = Member::findOne(Yii::$app->user->id);
        if ($model) {
            $model->setPin();
            $model->save();
            $this->money = Config::getValueConfig('m5_price');
            $this->money_current = $this->money;
            $this->member_id = Yii::$app->user->id;
            $this->status = self::STATUS_ACTIVE;
            $this->cycle_id = Cycle::current()->id;
            $this->type = static::TYPE_GIVE;
            if ($this->save()) {
                $this->addTimeEnd();

                LogsMember::create($this->id,$this->tableName(),$model->id,Yii::t('app','LOGS_MEMBER_GIVE_FORM'));
                $cycle = Cycle::find()->count();
                //vòng đầu tiên được cộng hoa hồng
                if (Cycle::current() && $cycle == 1) {
//                    die('co vao day k');
                    $this->getCountM5($model);
                }
                return TRUE;
            }
        }
        return FALSE;
    }

}
