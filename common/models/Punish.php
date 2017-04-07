<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "punish".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $table_id
 * @property string $table_name
 * @property integer $status
 * @property integer $count_give
 * @property string $create_at
 */
class Punish extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_START = 0;
    const COUNT_GIVE_ONE = 1;
    const COUNT_GIVE_TWO = 3;
    
    
    function getMember() {
        return $this->hasOne(Member::className(), ['id'=>'member_id' ]);
    }
    //
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'punish';
    }
    public static function create($member,$val) {
        $count = self::find()->where(['member_id'=>$member->id])->count();
        $countGive = self::COUNT_GIVE_ONE;
        $i = 1;
        if ($count == 0) {
            $member->role_id = Member::ROLE_PUNISH_ONE;
            $title = \Yii::t('app', 'LOGS_PUNISH_1');

        }
        if ($count == 1) {
            if ($member->punished) {
                $member->role_id = Member::ROLE_DISABLE;
                $member->punished->status = self::STATUS_START;
                $member->punished->save();;
                $i = 3;
                $title = \Yii::t('app', 'LOGS_PUNISH_3');
            }  else {
                $i = 2;
                $countGive = self::COUNT_GIVE_TWO;
                $member->role_id = Member::ROLE_PUNISH_TWO;
                $title = \Yii::t('app', 'LOGS_PUNISH_2');
            }
        }
        if ($count == 2) {
            $i = 3;
            $title = \Yii::t('app', 'LOGS_PUNISH_31');
            $member->role_id = Member::ROLE_DISABLE;
        }
        $punish = new Punish;
        $punish->table_id = $val->id;
        $punish->table_name = $val->tableName();
        $punish->count_give = $countGive;
        $punish->member_id = $member->id;
        $punish->status = self::STATUS_ACTIVE;
        $punish->save();
        if ($punish) {
            Logs::create($member->id, $punish->id, $punish->tableName(), $title, $member->id);
            LogsMember::create($punish->id,$punish->tableName(),$member->id,Yii::t('app',sprintf('LOGS_MEMBER_PUNISH_%d',$i)));
        }
        $member->save();
    }
    public function realize() {
        if ($this->count_give > 0) {
            $this->count_give--;
        }
        $isLog = true;
        if ($this->count_give == 0) {
            $this->status = self::STATUS_START;
            if ($this->member) {
                $this->member->role_id = Member::ROLE_ACTIVE;
                $this->member->save();
                $isLog = false;
                LogsMember::create($this->id,$this->tableName(),$this->member->id,Yii::t('app','LOGS_MEMBER_PUNISH_REALIZE_SUCCESS'));

            }
        }
        if ($isLog){
            LogsMember::create($this->id,$this->tableName(),$this->member_id,Yii::t('app','LOGS_MEMBER_PUNISH_REALIZE_ADD'));
        }
        $this->save();
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'table_id', 'status', 'count_give'], 'integer'],
            [['create_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'm5map_id' => Yii::t('app', 'M5map ID'),
            'status' => Yii::t('app', 'Status'),
            'count_give' => Yii::t('app', 'Count Give'),
            'create_at' => Yii::t('app', 'Create At'),
        ];
    }
}
