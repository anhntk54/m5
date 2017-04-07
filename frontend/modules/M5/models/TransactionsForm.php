<?php

namespace frontend\modules\M5\models;

use common\models\Transactions;
use common\models\Member;
use common\models\Logs;
use Yii;
use common\models\LogsMember;

/**
 * Signup form
 */
class TransactionsForm extends Transactions {
    public $password;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['count', 'member_id','password'], 'required'],
            [['count'], 'integer'],
            [['password'], 'string'],
            ['count', 'checkCountPin'],
            ['member_id', 'checkMember']
        ];
    }

    public function attributeLabels() {
        return [
            'member_id' => Yii::t('app', 'PIN_MEMBER_RECEIVE'),
            'count' => Yii::t('app', 'PIN_BUY_COUNT'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

    public function checkMember($attribute, $params) {
        if ($this->member_id == \Yii::$app->user->id) {
            $this->addError($attribute, Yii::t('app', 'COUNT_NOT_PIN_MEMBER'));
        }
    }

    public function checkCountPin($attribute, $params) {
        $member = Member::findOne(Yii::$app->user->id);
        if ($member) {
            $count = $member->pin;
            if ($this->count > $count) {
                $this->addError($attribute, Yii::t('app', 'COUNT_PIN_ERROR'));
            }
            if (!$member->validatePassword($this->password)) {
                $this->addError('password', Yii::t('app', 'PASSWORD_FAIL'));
            }
        }
    }

    public function saveData() {
        $member = Member::findOne(Yii::$app->user->id);
        if ($member) {
            $count = $member->pin;
            if ($count >= $this->count) {
                $i = 0;
                $m = Member::findOne($this->member_id);
                $this->table_name = $member->tableName();
                if ($m) {
                    $member->pin -= $this->count;
                    $m->pin += $this->count;
                    $member->save();
                    $m->save();
                    $this->member_id = $member->id;
                    $this->table_id = $m->id;
                    $title = sprintf(\Yii::t('app', 'LOGS_CREATE_SEND_PIN'),  $this->count,$member->getDisplayName());
                    Logs::create($this->member_id, $this->member_id, $this->tableName(), $title, $member->id);
                    $log = sprintf(Yii::t('app','LOGS_MEMBER_GIVE_PINS'),$this->count,$m->username);
                    $this->save(false);
                    LogsMember::create($this->id,$this->tableName(),$member->id,$log);
                    $log = sprintf(Yii::t('app','LOGS_MEMBER_GIVE_PINS_RECEIVE'),$this->count,$member->username);
                    LogsMember::create($this->id,$this->tableName(),$m->id,$log);
                    return TRUE;
                }
            }
        }
        return true;
    }

}
