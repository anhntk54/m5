<?php
namespace frontend\modules\Member\models;

use common\models\Member;
use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\Member',
                'message' => 'Không tồn tại email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = Member::findOne([
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!Member::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }
        
        if (!$user->save()) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([\Yii::$app->params['supportEmail'] => Yii::t('app', 'EMAIL_TITLE_SEND')])
            ->setTo($this->email)
            ->setSubject(\Yii::t('app', 'SUBJECT_TITLE_RESET_PASSWORD'))
            ->send();
    }
}
