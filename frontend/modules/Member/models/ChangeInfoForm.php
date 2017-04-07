<?php

namespace frontend\modules\Member\models;

use common\models\LogsMember;
use common\models\Member;
use Yii;

/**
 * Signup form
 */
class ChangeInfoForm extends Member {

    public $change_avatar;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['change_avatar'],'integer'],
            [['mobile', 'bank_code', 'bank_name', 'bank_agency',
            'avatar', 'card_id', 'gender', 'birth_day','display_name','bank_username'], 'string']
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
        $model = $this;
        if ($model) {
            if ($this->avatar != '' && $model->avatar != '' && $this->change_avatar == 1) {
                $pathOld = Yii::getAlias('@webroot') . $model->avatar;
                if (is_file($pathOld)) {
                    unlink($pathOld);
                }
            }
            if ($this->change_avatar == 1) {
                $path = \common\func\FunctionCommon::createFolder(Yii::getAlias("@pathimage") . '/avatar/');
                $nameImage = '/uploads/images/avatar/' . date('Y') . '/' . date('m') . '/' . $this->avatar;
                $pathOld = Yii::getAlias("@pathimage") . '/avatar/temp/' . $this->avatar;
                $pathNew = $path . $this->avatar;
                if (rename($pathOld, $pathNew)) {
                    $model->avatar = $nameImage;
                }
            }
            $model->mobile = $this->mobile;
            $model->card_id = $this->card_id;
            $model->display_name = $this->display_name;
            $model->bank_agency = $this->bank_agency;
            $model->bank_code = $this->bank_code;
            $model->bank_name = $this->bank_name;
            $model->birth_day = $this->birth_day;
            $model->gender = $this->gender;
            LogsMember::create($model->id,$model->tableName(),$model->id,Yii::t('app','LOGS_MEMBER_CHANGE_INFO'));
            return $model->save();
        }
        return FALSE;
    }

}
