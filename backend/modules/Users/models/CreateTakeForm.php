<?php

namespace backend\modules\Users\models;

use Yii;
use common\models\Member;
/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class CreateTakeForm extends \yii\db\ActiveRecord {

    public $member_id,$is_take;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['member_id','is_take'], 'integer']
        ];
    }
    public function saveData() {
        foreach ($this->member_id as $id) {
            $member = Member::findOne($id);
            if ($member) {
                $member->role_id = $this->is_take;
                $member->save();
            }
        }
        return TRUE;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'is_take' => 'Chọn thao tác',
            'nameApp' => 'Tên hệ thống',
        ];
    }

}
