<?php

namespace common\models;
use common\func\FunctionCommon;
use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $member_action
 * @property integer $table_id
 * @property string $table_name
 * @property integer $count
 * @property integer $money
 * @property integer $status
 * @property string $type
 * @property string $created_at
 */
class Transactions extends \yii\db\ActiveRecord {

    const STATUS_START = 0;
    const SATTUS_SUCCESS = 5;
    const TYPE_PIN = "Pin";
    const TYPE_ROSES = "Roses";

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'transactions';
    }

    function getMember() {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }

    function getMemberaction() {
        return $this->hasOne(Member::className(), ['id' => 'table_id'])->viaTable("transactions", ['id'=>'id'], function ($query) {
                    $query->where(['table_name'=>  Member::tableName()]);
                });
    }
    function getM5() {
        return $this->hasOne(M5::className(), ['id' => 'table_id'])->viaTable("transactions", ['id'=>'id'], function ($query) {
                    $query->where(['table_name'=> M5::tableName()]);
                });
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['member_id', 'table_id', 'count', 'money', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['type'], 'string', 'max' => 255]
        ];
    }
    public static function getCountOfWeek($model,$date = '',$type = self::TYPE_ROSES)
    {
        if ($date == '') {
            $date = date('Y-m-d');
        }
        $dateOfWeek = FunctionCommon::getWeek($date);
        $firstWeek = $dateOfWeek[0];
        $weekend = $dateOfWeek[1];
        $count = Transactions::find()->where(['>','created_at',$firstWeek])->andWhere(['<','created_at',$weekend])->andWhere(['member_id'=>$model->id,'type'=>$type])->count();
        return $count;
    }
    public static function create($member_id, $table_id,$table_name, $count, $money, $type) {
        $model = new Transactions;
        $model->table_id = $table_id;
        $model->table_name = $table_name;
        $model->member_id = $member_id;
        $model->money = $money;
        $model->count = $count;
        $model->type = $type;
        $model->status = self::STATUS_START;
        $model->save();
        return $model;
    }

    public function run() {
        $isSave = FALSE;
        if ($this->type == self::TYPE_PIN && $this->table_id == 0) {
            for ($index = 0; $index < $this->count; $index++) {
                $val = new Pin();
                $val->member_id = $this->member_id;
                $val->code = $val->getPinCode();
                $val->save();
            }
            $isSave = TRUE;
        }
        if ($isSave) {
            $this->status = self::SATTUS_SUCCESS;
            $this->save();
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'member_action' => Yii::t('app', 'Member Action'),
            'table_id' => Yii::t('app', 'Table ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'count' => Yii::t('app', 'PIN_BUY_COUNT'),
            'money' => Yii::t('app', 'Money'),
            'status' => Yii::t('app', 'Status'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

}
