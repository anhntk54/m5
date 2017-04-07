<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $member_action
 * @property integer $table_id
 * @property integer $table_name
 * @property string $title
 * @property string $type
 * @property integer $is_view
 * @property string $created_at
 */
class Logs extends \yii\db\ActiveRecord
{
    const TYPE_SYSTEM = "system";
    const TYPE_USER = "user";
    const VIEW_BEGIN = 0;
    const VIEW_END = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs';
    }
    function getMemberaction() {
        return $this->hasOne(Member::className(), ['id' => 'member_action']);
    }
    function getMember() {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'member_action', 'table_id', 'table_name', 'is_view'], 'integer'],
            [['title'], 'string'],
            [['created_at'], 'safe'],
            [['type'], 'string', 'max' => 255]
        ];
    }
    public function getLink() {
        return '#';
    }
    public function getTime() {
        $rem = time() - strtotime($this->created_at);
        $day = floor($rem / 86400);
        if ($day > 2) {
            return date('d-m-y',  strtotime($this->created_at));
        }
        if ($day == 1) {
            return "1 ngày trước";
        }
        $hr = floor(($rem % 86400) / 3600);
        if ($hr > 0) {
            return "$hr giờ trước";
        }
        $min = floor(($rem % 3600) / 60);
        if ($min > 0) {
            return "$min phút trước";
        }
        return "Vừa xong";
    }
    public function getTitle() {
        return $this->title;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'member_action' => Yii::t('app', 'Member Action'),
            'table_id' => Yii::t('app', 'Table ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'title' => Yii::t('app', 'Title'),
            'type' => Yii::t('app', 'Type'),
            'is_view' => Yii::t('app', 'Is View'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
    public static function create($member_id, $table_id, $table_name, $title,$member_action = 0,$type = self::TYPE_USER ) {
        if ($member_action == 0) {
            $member_action = $member_id;
        }
        $log = new Logs;
        $log->member_id = $member_id;
        $log->member_action = $member_action;
        $log->table_id = $table_id;
        $log->table_name = $table_name;
        $log->title = $title;
        $log->type = $type;
        $log->save(FALSE);
    }
}
