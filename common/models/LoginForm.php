<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $_class = "member";
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'MEMBER_SIGNUP_USERNAME'),
            'password' => Yii::t('app', 'MEMBER_SIGNUP_PASSWORD'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, \Yii::t('app', 'MEMBER_LOGIN_FAIL'));
            }  else {
                if ($user->tableName() == Member::tableName() && $user->status == Member::STATUS_NOT_ACTIVE) {
                    $this->addError($attribute, \Yii::t('app', 'MEMBER_LOGIN_FAIL_NOT_ACTIVE'));
                }
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            var_dump(Yii::$app->user->login($this->getUser(),10));
            var_dump(\Yii::$app->user->isGuest);
//            die("lkd");
            return Yii::$app->user->login($this->getUser(),10);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Member::findByUsername($this->username);
            if ($this->_class == "user") {
                $this->_user = User::findByUsername($this->username);
            }
        }

        return $this->_user;
    }
}
