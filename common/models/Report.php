<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property integer $id
 * @property integer $m5map_id
 * @property integer $member_id
 * @property string $created_at
 * @property string $type
 */
class Report extends \yii\db\ActiveRecord {

    const TYPE_NOT_ACCEPT = "not_accept";
    const TYPE_NOT_SEND = "not_send";
    const TYPE_SEND = "send";
    const TYPE_END = "end";
    const RESULT_SUCCESS = 1;
    const RESULT_START = 0;

    public static function getTextResult() {
        return [
            self::RESULT_START => "Chưa thực hiện",
            self::RESULT_SUCCESS => "Thành công",
        ];
    }

    public static function getTypes() {
        return [
            self::TYPE_NOT_SEND => 'Chưa gửi tiền',
            self::TYPE_SEND => 'Đã gửi tiền',
            self::TYPE_NOT_ACCEPT => 'Chưa xác nhận',
            self::TYPE_END => 'Kết thúc',
        ];
    }
    public function getTimeEnd() {
        $date = $this->date_end;
        $s = date('s', strtotime($date));
        if ($s <= 5) {
            $date = date('Y-m-d H:i:s', strtotime("+20 seconds ", strtotime($date)));
        }
        $rem = strtotime($date) - time();
        if ($rem < 0) {
            return Yii::t('app', 'SATTUS_M5_FINSH');
        }
        $day = floor($rem / 86400);
        $hr = floor(($rem % 86400) / 3600);
        $min = floor(($rem % 3600) / 60);
        $sec = ($rem % 60);
        $t = '';
        if ($day)
            $t = "$day: ";
        $t.= $hr < 10 ? "0$hr:" : "$hr:";
        $t .=$min < 10 ? "0$min:" : "$min:";
        $t .=$sec < 10 ? "0$sec" : "$sec";
        return $t;
    }
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'report';
    }

    function getM5map() {
        return $this->hasOne(M5Map::className(), ['id' => 'm5map_id']);
    }
    function getMember() {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['m5map_id', 'member_id', 'type'], 'required'],
            [['m5map_id', 'member_id'], 'integer'],
            [['created_at'], 'safe'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    public static function setReport($m5map_id, $member_id, $type = self::TYPE_SEND) {
        $model = new Report;
        $model->m5map_id = $m5map_id;
        $model->member_id = $member_id;
        $model->type = $type;
        $model->save();
        return $model;
    }

    public function checkFinish() {
        $map = $this->m5map;
        if ($this->result == self::RESULT_START) {
            if ($this->type == self::TYPE_SEND) {
                $map->Finish(); //
            }
            if ($this->type == self::TYPE_NOT_ACCEPT) {
                // Ban thằng GD và xác nhận thành công cho thằng PD
                $map->Finish(TRUE); //
            }
            if ($this->type == self::TYPE_NOT_SEND) {

                $map->End();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'm5map_id' => Yii::t('app', 'M5map ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'content' => Yii::t('app', 'Content'),
            'type' => Yii::t('app', 'Type'),
            'date_end' => Yii::t('app', 'Date End'),
        ];
    }

}
