<?php

namespace backend\modules\M5\models;
use common\models\M5Map;
use common\models\Cycle;
use common\models\M5;
use common\models\Member;
use common\models\Config;
use Yii;

/**
 * Signup form
 */
class CreateMemberTake extends M5 {

    public $member_id;
    public $m5_id;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['member_id'],'required'],
            [['member_id', 'm5_id'], 'integer'],
        ];
    }

    public function checkValidate($attribute, $params) {
    }

    public function saveData() {
        $member = Member::findOne($this->member_id);
        $give = M5::findOne($this->m5_id);
        if ($member && $give && $give->isCreateMemberTake()) {
            $money = $give->money_current;
            if ($money > 0 && $member->id != $give->member_id) {
                $m5 = self::createM5($money, 0, $this->member_id, self::TYPE_TAKE_MEMBER_AUTO, self::STATUS_TAKE, 0);
                if ($m5) {
                    $m5->addTimeEnd();
                    $map = M5Map::createM5Map($money, $give->member_id, $this->member_id, $m5->id, $give->id);
                    $give->money_current = 0;
                    $give->save();
                }
            }
            return TRUE;
        }
        return FALSE;
    }

}
