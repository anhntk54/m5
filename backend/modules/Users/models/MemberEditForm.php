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
class MemberEditForm extends Member {

    function __construct() {
        $this->status = static::STATUS_NOT_ACTIVE;
        $this->role_id = static::ROLE_ACTIVE;
    }

    public function getRoles() {
        return [
            static::ROLE_DISABLE => 'Không có quyền',
            static::ROLE_ACTIVE => 'Người dùng bình thường',
            static::ROLE_TAKE => 'Được quyền nhận',
        ];
    }

    public function getStatus() {
        return [
            static::STATUS_NOT_ACTIVE => 'Chưa kích hoạt',
            static::STATUS_BAN => 'Ban người dùng',
            static::STATUS_ACTIVE => 'Người dùng bình thường',
            self::STATUS_AUTO_TAKE => 'Người dùng được đăng ký nhận tiền'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['mobile', 'email', 'status'], 'required'],
            [['mobile', 'email', 'card_id'], 'unique'],
            [['parent_id', 'status', 'role_id', 'level_id','count_role'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 20],
            [['mobile'], 'string', 'max' => 11],
            [['password', 'password_hash', 'password_reset_token', 'auth_key', 'key_member', 'bank_code', 'bank_name', 'bank_agency', 'display_name', 'card_id'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50]
        ];
    }

    public function saveData() {
        if ($this->password != '') {
            $this->setPassword($this->password);
        }
        if ($this->role_id < 0) {
            $this->count_role = 0;
        }
        $this->key_member = $this->getKeyMember();
        $this->created_at = date('Y-m-d H:i:s');
        $this->save();
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
