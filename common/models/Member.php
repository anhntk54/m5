<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\func\FunctionCommon;
use yii\db\ActiveRecord;
use common\models\Level;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property integer $m5_id
 * @property integer $pin
 * @property integer $parent_id
 * @property string $username
 * @property string $display_name
 * @property string $mobile
 * @property string $password_hash
 * @property string $bank_code
 * @property string $bank_name
 * @property string $bank_agency
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $card_id
 * @property string $key_member
 * @property integer $status
 * @property integer $role_id
 * @property integer $count_role
 * @property integer $created_at
 * @property string $password write-only password
 */
class Member extends ActiveRecord implements IdentityInterface {

    const STATUS_NOT_ACTIVE = 1; // member chưa active
    const STATUS_ACTIVED = 5; // member chưa active
    const STATUS_ADD_INFO = 3; // member chưa active
    const STATUS_ADD_BANK = 4; // member chưa active
    const STATUS_ACTIVE = 2; // member dùng bình thườn
    const STATUS_BAN = -2; // member bị ban
    const STATUS_AUTO_TAKE = 6; // member bị ban
    const ROLE_ACTIVE = 1;
    const ROLE_TAKE = 2; // Người dùng có thể nhận tiền khi trò chơi bắt đầu
    const ROLE_DISABLE = -10;
    const ROLE_PUNISH_ONE = -2;
    const ROLE_PUNISH_TWO = -3;
    const NUMBER_CODE_STRING = 5;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
        ];
    }

    function getGives() {
        return $this->hasMany(M5::className(), ['member_id' => 'id'])->where(['type' => 'give']);
    }

    function getGivepin() {
        return $this->hasMany(Transactions::className(), ['table_id' => 'id'])->where(['table_name' => self::tableName(), 'type' => Transactions::TYPE_PIN]);
    }

    function getRoses() {
        return $this->hasMany(Transactions::className(), ['member_id' => 'id'])->where(['type' => Transactions::TYPE_ROSES]);
    }

    function getGivecycle() {
        if (Cycle::current()) {
            return $this->hasMany(M5::className(), ['member_id' => 'id'])->where(['type' => 'give', 'cycle_id' => Cycle::current()->id]);
        }
    }

    function getM5give($status = 1) {
        return $this->hasOne(M5::className(), ['member_id' => 'id'])->where(['type' => 'give', 'status' => $status]);
    }

    function getM5take($status = 1) {
        return $this->hasOne(M5::className(), ['member_id' => 'id'])->where(['type' => 'take', 'status' => $status]);
    }

    function getTakes($status = 1) {
        return $this->hasMany(M5::className(), ['member_id' => 'id'])->where(['!=', 'type', M5::TYPE_GIVE]);
    }

    function getPunished() {
        return $this->hasOne(Punish::className(), ['member_id' => 'id'])->where(['status' => Punish::STATUS_ACTIVE]);
    }

    function getM5current() {
        return $this->hasOne(M5::className(), ['id' => 'm5_id']);
    }

    function getParent() {
        return $this->hasOne(Member::className(), ['id' => 'parent_id']);
    }

    function getLevel() {
        return $this->hasOne(Level::className(), ['id' => 'level_id']);
    }

    function getChilds() {
        return $this->hasMany(Member::className(), ['parent_id' => 'id']);
    }

    function getPins() {
        return $this->hasMany(Pin::className(), ['member_id' => 'id'])->where(['status' => 0]);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::find()->where(['id' => $id])->andWhere(['>=', 'status', self::STATUS_ACTIVE])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function _delete() {
        $this->delete();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        return $this->password_hash;
    }

    public function getPassword($password) {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function getAvatar() {
        if ($this->avatar == NULL) {
            $this->avatar = "/uploads/images/avatar/default-avatar.png";
        }
        return Config::getValueConfig('baseUrl') . $this->avatar;
    }

    public function getDisplayName() {
        $title = $this->display_name;
        if ($title == null) {
            $title = $this->username;
        }
        return $title;
    }

    public function getHtmlAvatar($options = []) {
        return \yii\helpers\Html::img($this->getAvatar(), $options);
    }

    public function getKeyMember() {
        $code = '';
        do {
            $code = \common\func\FunctionCommon::random_code(static::NUMBER_CODE_STRING);
            $model = Member::findOne(['key_member' => $code]);
            if (!$model) {
                break;
            }
        } while (true);
        return $code;
    }

    public function changeLevel() {
        if ($this) {
            // tìm phần tử cha xem có đủ điều kiện lên cấp độ hay k
            $parent = $this->parent;
            if ($parent) {
                $typeLevel = $parent->level->type + 1;
                $levelNext = Level::findOne(['type' => $typeLevel]);
                if ($levelNext) {
                    // số lượng cấp độ của phần tử con
                    $childsParentCount = $parent->getChilds()->where(['level_id' => $parent->level_id])->count();
                    if ($childsParentCount >= $levelNext->condition) {
                        $parent->level_id = $levelNext->id;
                        if ($parent->save()) {
                            $title = sprintf(\Yii::t('app', 'LOGS_MEMBER_CHANGE_LEVER'),$levelNext->name);
                            Logs::create($parent->id, $parent->id, $parent->tableName(), $title, $parent->id);
                            $parent->changeLevel();
                        }
                    }
                }
            }
        }
    }

    public function getParentMember($level) {
        if ($level > 0) {
            if ($this->parent) {
                $level--;
                return $this->parent->getParentMember($level);
            }
        } else if ($level == 0) {
            return $this;
        } else {
            return NULL;
        }
    }

    public function addCountM5() {
        if ($this->count_m5 >= 0) {
            $this->count_m5++;
        }
        $count = Config::getValueConfig('m5_count_pd');
        if ($this->count_m5 >= $count) {
            $money = Config::getValueConfig('m5_price');
            $this->money_roses += $money;
            $title = sprintf(\Yii::t('app', 'LOGS_MEMBER_CREATE_ROSER'),  FunctionCommon::formatMoney($money),$count);
            Logs::create($this->id, $this->id, $this->tableName(), $title, $this->id);
            $this->count_m5 = -1;
            LogsMember::create($this->id,$this->tableName(),$this->id,Yii::t('app','LOGS_MEMBER_TASK_SUCCESS'));
        }
        $this->save(FALSE);
        if ($this->parent) {
            $this->parent->addCountM5();
        }
    }

    /*
     * Tạo give khi người dùng con k gửi tiền
     */

    public function createSupportMemberChild($map) {
        $money = $map->money;
        $take_id = $map->m5_take_id;
        $give_id = $map->m5_give_id;
        $member_id = $map->member_id;
        $member_action = $this->id;
        $take = $map->m5take;
        $m5 = M5::createM5($money, 0, $member_action, M5::TYPE_GIVE, M5::STATUS_TAKE_LIST, $give_id);
        if ($m5) {
            $map = M5Map::createM5Map($money, $member_action, $member_id, $take_id, $m5->id);
            $m5->addTimeEnd(1);
            return $map;
        }
    }

    /*
     * Hàm này chạy khi ứng dụng chưa chạy sẽ tạo một lần cho nhận với những người chơi được nhận tiền khi bắt đầu chơi game
     *
     */

    public function createM5Give() {
        $money = Config::getValueConfig('m5_price');
        $count = $this->count_role;
        
        if ($count > 0) {
            for ($index = 0; $index < $count; $index++) {
                $m5 = M5::createM5($money, $money, $this->id, M5::TYPE_TAKE_USER, M5::STATUS_ACTIVE, 0);

                if ($m5->save(FALSE)) {
                    $title = sprintf(Yii::t('app', 'LOGS_GD_SUCCESS'), $money);
                    Logs::create($this->id, $m5->id, $m5->tableName(), $title, $this->id);
                }
            }
        }
        LogsMember::create($this->id,$this->tableName(),$this->id,sprintf(Yii::t('app','LOGS_MEMBER_TAKS_FORM'),$this->count_role));
        $this->role_id = Member::ROLE_ACTIVE;
        $this->count_role = 0;
        $this->save();
    }

    public function setPin() {
        if ($this->pin > 0) {
            $this->pin--;
        }
    }

    //anhtrieunhu
    /**
     * Lấy các member cấp dưới
     */
    public function getMemberLevel() {
        
    }

    public function getMemberPD($t) {
        $childs = $this->childs;
        if (count($childs) == 0) {
            $gives = $this->gives;
            if (count($gives) > 0) {
                $t += 1;
            }
        } else {
            foreach ($childs as $value) {
                $t += $value->getMemberPD($t);
            }
        }
        return $t;
    }
    public static function getMemberAutoTake(){
        $user = null;
        $model = self::find()->where(['status'=>self::STATUS_AUTO_TAKE])->all();
        foreach ($model as $value){
            $takes = $value->getTakes()->andWhere(['status'=>M5::STATUS_FINISH])->count();
            if ($takes == 0){
                $user = $value;
                break;
            }
        }
        if (!$user){
            $user = $u = Member::getRandom(null,['limit'=>1,'condition'=>['status'=>6]]);;
        }
        return $user;
    }
    function getTree($parentID) {
        $model = self::find()->where(['parent_id' => $parentID])->asArray()->all();

        $tree = array();
        $idList = array();
        foreach ($model as $row) {
//            die(var_dump($row));
            $row['children'] = array();
            $tree[$row['id']] = $row;
            $idList[] = $row['id'];
        }

        if ($idList) {
            $children = $this->getTree($idList);
            foreach ($children as $child) {
                $tree[$child['parent_id']]['children'][] = $child;
            }
        }
        return $tree;
    }
    public static function getRandom ( $columns = null, array $options = [] ) {
        $condition = isset($options['condition']) ? $options['condition'] : [];
        $asArray = isset($options['asArray']) ? $options['asArray'] : false;
        $callback = isset($options['callback']) ? $options['callback'] : null;
        $limit = isset($options['limit']) ? $options['limit'] : 1;
        $query = static::find()
            ->select($columns)
            ->where($condition)
            ->orderBy(new \yii\db\Expression('rand()'))
            ->limit((int)$limit);
        if ( $asArray ) {
            $query->asArray(true);
        }
        if ( is_callable($callback) ) {
            call_user_func_array($callback, [&$query]);
        }
        return $limit === 1
            ? $query->one()
            : $query->all();
    }
}
