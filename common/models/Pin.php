<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pin".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $code
 * @property integer $status
 */
class Pin extends \yii\db\ActiveRecord
{
    const STAUS_UNUSED = 0;
    const STAUS_USE = 1;

    public $count_code;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id'], 'required'],
            ['member_id','checkMember'],
            [['status','count_code'], 'integer'],
            [['code'], 'string', 'max' => 255]
        ];
    }
    
    public function checkMember($attribute, $params)
    {
        $model = Member::findOne($this->member_id);
        if (!$model) {
            $this->addError($attribute, 'Không tồn tại member');
        }
    }
    public function getPinCode() {
        $code = '';
        do {
            $code = \common\func\FunctionCommon::random_code(6);
            $model = static::findOne(['code' => $code]);
            if (!$model) {
                break;
            }
        } while (true);
        return $code;
    }
    public function getStatus() {
        return [self::STAUS_UNUSED=>  Yii::t('app', 'PIN_STATUS_UNUSE'),  self::STAUS_USE=>Yii::t('app', 'PIN_STATUS_USE')];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
