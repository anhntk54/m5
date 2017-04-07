<?php

namespace frontend\modules\Member\models;

use common\models\Member;
use Yii;
use common\models\LogsMember;
/**
 * Signup form
 */
class InfoForm extends Member {
    const SCENARIO_INFO = 'info';
    const SCENARIO_BANK = 'bank';
    public $change_avatar;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['change_avatar'],'integer'],
            [['mobile', 'bank_code', 'bank_name', 'bank_agency',
            'avatar', 'card_id', 'gender', 'birth_day','display_name'], 'string'],
            [['bank_code', 'bank_name', 'bank_agency','bank_username'], 'required','on'=>self::SCENARIO_BANK],
            [['mobile', 'card_id'], 'required','on'=>self::SCENARIO_INFO],
            [['mobile'], 'match', 'pattern' => '/^(84|0)(1\d{9}|9\d{8})$/','on'=>self::SCENARIO_INFO],
            [['mobile', 'card_id'], 'unique','on'=>self::SCENARIO_INFO]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bank_code' => Yii::t('app', 'BANK_CODE'),
            'bank_name' => Yii::t('app', 'BANK_NAME'),
            'bank_agency' => Yii::t('app', 'BANK_AGENCY'),
            'card_id' => Yii::t('app', 'CARD_ID'),
            'bank_username' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_USER_NAME'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function changInfo() {
        if ($this){
            if ($this->scenario == self::SCENARIO_BANK){
                $this->status = self::STATUS_ACTIVED;
                LogsMember::create($this->id,$this->tableName(),$this->id,Yii::t('app','LOGS_MEMBER_CHANGE_BEGIN_INFO'));
            }
            if ($this->scenario == self::SCENARIO_INFO){
                $this->status = self::STATUS_ADD_INFO;
            }
            $this->save();
            return true;
        }
        return FALSE;
    }

}
