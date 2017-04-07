<?php

namespace frontend\modules\Member\models;

use common\models\LogsMember;
use common\models\Member;
use yii\base\Model;
use common\models\Email;
use yii\helpers\Url;
use Yii;
use common\models\Config;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;

    public function attributeLabels() {
        return [
            'username' => Yii::t('app', 'MEMBER_SIGNUP_USERNAME'),
            'email' => Yii::t('app', 'MEMBER_SIGNUP_EMAIL'),
            'password' => Yii::t('app', 'MEMBER_SIGNUP_PASSWORD'),
        ];
    }

    public function checkUserName($attribute, $params) {
        if (is_numeric($this->username)) {
            $this->addError($attribute, Yii::t('app', 'MEMBER_CREATE_FAIL_USERNAME_NOT_TEXT'));
        }
        if ($this->checkUserAdmin($this->username)) {
            $this->addError($attribute, Yii::t('app', 'MEMBER_SIGNUP_UNIQUE_USERNAME'));
        }
    }

    public function checkUserAdmin($str) {
        $list = [
            'admin',
            'mod',
            'administrator',
            'quantri',
        ];
        foreach ($list as $value) {
            if (stripos(strtolower($str), strtolower($value)) !== false) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'checkUserName'],
            ['username', 'unique', 'targetClass' => '\common\models\Member', 'message' => \Yii::t('app', 'MEMBER_SIGNUP_UNIQUE_USERNAME')],
            ['username', 'string', 'min' => 6, 'max' => 20],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Member', 'message' => \Yii::t('app', 'MEMBER_SIGNUP_UNIQUE_USERNAME')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($model) {
        if (!$this->validate()) {
            return null;
        }
        $parent_id = 0;
        $info = "";
        if (!Yii::$app->user->isGuest) {
            $model = Member::findOne(Yii::$app->user->id);
            $info = "<br>Tên đăng nhập của bạn:" . $this->username . '<br>' . "Mật khẩu của bạn:" . $this->password . '<br>';
        }
        if ($model) {
            $parent_id = $model->id;
        }

        $user = new Member();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->key_member = $user->getKeyMember();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->parent_id = $parent_id;
//        $user->created_at = date('Y-m-d H:i:s');
        if ($user->save()) {
            $link = Config::getValueConfig('baseUrl') . Url::to(['/Member/default/activate', 'id' => $user->id, 'key' => $user->auth_key]);
            $content = "Chúc mừng bạn đã đăng ký tài khoản thành công." . $info
                    . " Click link dướng đây để kích hoạt tài khoản <br>"
                    . "<a href='$link'>Kích hoạt</a>";
            Email::create($user->email, "Kích hoạt tài khoản", $content);
            LogsMember::create($user->id,$user->tableName(),$parent_id,Yii::t('app','LOGS_MEMBER_CREATE_MEMBER'));
            $user->changeLevel();
        }
        return $user ? $user : null;
    }

}
