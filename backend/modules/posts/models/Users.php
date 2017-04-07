<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $mobile
 * @property string $password
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property integer $role_id
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $passwordRepeat;
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'username', 'mobile', 'password', 'email', 'status', 'role_id'], 'required'],
            [['id', 'status', 'role_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['passwordRepeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
            [['username'], 'string', 'max' => 20],
            [['mobile'], 'string', 'max' => 11],
            [['password', 'password_hash', 'password_reset_token', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'password' => 'Password',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'role_id' => 'Role ID',
        ];
    }
}
