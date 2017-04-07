<?php

namespace frontend\modules\Member\models;

use common\models\Member;
use yii\base\Model;
use Yii;
use common\models\LogsMember;

/**
 * Signup form
 */
class ChangePasswordForm extends Model {

    public $password_old;
    public $password_repeat;
    public $password;
    public function attributeLabels()
    {
        return [
            'password_old' => Yii::t('app', 'MEMBER_CHANGE_PASSWORD_OLD'),
            'password_repeat' => Yii::t('app', 'MEMBER_CHANGE_PASSWORD_REPEAT'),
            'password' => Yii::t('app', 'MEMBER_CHANGE_PASSWORD_NEW'),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['password_old','validatePasswordOld','enableClientValidation' => TRUE],
            [['password','password_old','password_repeat'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'enableClientValidation' => TRUE],
            ['password', 'string', 'min' => 6],
        ];
    }
    public function validatePasswordOld($attribute, $params)
    {
        $model = Member::findOne(Yii::$app->user->id);
        if ($model && !$model->validatePassword($this->password_old)) {
            $this->addError($attribute, \Yii::t('app', 'MEMBER_CHANGE_PASSWORD_OLD_FAIL'));
        }
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function changepassword() {
        $model = Member::findOne(Yii::$app->user->id);
        if ($model) {
            $model->setPassword($this->password);
            LogsMember::create($model->id,$model->tableName(),$model->id,Yii::t('app','LOGS_MEMBER_CHANGE_PASSWORD'));
            return $model->save();
        }
        return FALSE;
    }

}
